<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\DataSourceApiInterface;
use App\Repositories\LeagueRepository;
use App\Repositories\SportRepository;
use App\Repositories\TeamRepository;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SportdataFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sportdata:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the database with info from thesportsdb.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        DataSourceApiInterface $apiInterface,
        SportRepository $sportRepository,
        LeagueRepository $leagueRepository,
        TeamRepository $teamRepository
    )
    {
        $remoteSports = $apiInterface->fetchSports();
        foreach ($remoteSports as $sport) {
            $sportRepository->save($sport);
        }
        $remoteLeagues = $apiInterface->fetchLeagues();
        $localSports = $sportRepository->allByKey();
        foreach ($remoteLeagues as $league) {
            $leagueSportName = Str::lower($league['sport_name']);
            if ($localSports->has($leagueSportName)) {
                $league['sport_id'] = $localSports->get($leagueSportName)->id;
                $leagueRepository->save($league);
                $teams = $apiInterface->fetchTeams($league['id']);
                foreach ($teams as $team) {
                    $teamRepository->save($team);
                }
                usleep(500000);
            } else {
                Log::warning('A sport id was not found for '.$leagueSportName);
            }

            /*var_dump($league);
            $teams = $apiInterface->fetchTeams($league->id);
            foreach ($teams as $team) {
                var_dump($team);
            }
            $standings = $apiInterface->fetchStandings($league->id);
            foreach ($standings as $standing) {
                var_dump($standing);
            }*/
        }
        return Command::SUCCESS;
    }
}

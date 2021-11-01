<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\DataSourceApiInterface;
use App\Interfaces\LeagueRepositoryInterface;
use App\Interfaces\SportRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;

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
        SportRepositoryInterface $sportRepository,
        LeagueRepositoryInterface $leagueRepository,
        TeamRepositoryInterface $teamRepository,
        StandingRepositoryInterface $standingRepository
    ) {

        $this->info('Starting sports import.');
        $remoteSports = $apiInterface->fetchSports();
        foreach ($remoteSports as $sport) {
            $sportRepository->save($sport);
        }
        $this->info('Sports import finished.');



        $this->info('Starting import for leagues.');
        $remoteLeagues = $apiInterface->fetchLeagues();

        //First loop through teams that are needed for both teams & standings
        foreach ($remoteLeagues as $league) {
            $leagueRepository->save($league);
        }
        $this->info('Leagues import finished.');


        //Loop through the leagues again to import related teams
        $this->info('Starting import for league teams.');
        $leaguesProgressBar = $this->output->createProgressBar($remoteLeagues->count());

        foreach ($remoteLeagues as $league) {
            $remoteTeams = $apiInterface->fetchTeams($league['remote_id']);
            foreach ($remoteTeams as $team) {
                $teamRepository->save($team);
            }
            $leaguesProgressBar->advance();
        }
        $leaguesProgressBar->finish();
        $this->info(PHP_EOL);
        $this->info('League teams import finished.');


        //One last loop through leagues to import related standings
        $this->info('Starting import for league standings.');
        $leaguesProgressBar = $this->output->createProgressBar($remoteLeagues->count());
        foreach ($remoteLeagues as $league) {
            $remoteStandings = $apiInterface->fetchStandings($league['remote_id']);
            foreach ($remoteStandings as $standing) {
                $standingRepository->save($standing);
            }
            $leaguesProgressBar->advance();
        }
        $leaguesProgressBar->finish();
        $this->info(PHP_EOL);
        $this->info('League team standings import finished.');


        return Command::SUCCESS;
    }
}

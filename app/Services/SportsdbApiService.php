<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\DataSourceApiInterface;
use Illuminate\Support\Collection;
use Exception;

class SportsdbApiService implements DataSourceApiInterface
{
    protected static $sportsdb_base_url = 'https://www.thesportsdb.com/api/v1/json/1/';

    /**
     * Returns response from the API as a collection
     * The entriesIndex is returned if it exists within the response
     * Otherwise the whole response is returned
     *
     * @param string $endpoint
     * @param string $entriesIndex
     *
     * @return Collection
     */

    public function getApiEntries($endpoint, $entriesIndex)
    {
        if (!$endpoint) {
            throw new Exception('Endpoint was not defined');
        }
        $url = self::$sportsdb_base_url.$endpoint;
        $response = Http::withoutVerifying()
                    ->acceptJson()
                    ->asJson()
                    ->get($url);
        if ($response->ok()) {
            $entries = $response->json();
            var_dump($entries);
            if ($entries && $entriesIndex && isset($entries[$entriesIndex])) {
                return collect($entries[$entriesIndex]);
            }
            throw new Exception('Empty response from sportsdb API received');
        }
    }

    public function fetchSports():Collection
    {
        $entries = $this->getApiEntries('all_sports.php', 'sports');
        return $entries;
    }

    public function fetchLeagues():Collection
    {
        $entries = $this->getApiEntries('all_leagues.php', 'leagues');
        return $entries;
    }

    public function fetchTeams(int $league_id):Collection
    {
        if (!is_int($league_id) || $league_id <= 0) {
            throw new Exception('Invalid league id used');
        }
        $entries = $this->getApiEntries('lookup_all_teams.php?id='.$league_id, 'teams');
        return $entries;
    }

    public function fetchStandings(int $team_id):Collection
    {
        if (!is_int($team_id) || $team_id <= 0) {
            throw new Exception('Invalid league id used');
        }
        $entries = $this->getApiEntries('lookup_all_teams.php?id='.$team_id, 'table');
        return $entries;
    }
}

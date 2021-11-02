<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\DataSourceApiInterface;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;

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
            if (config('logging.log_application_warnings')) {
                Log::warning('No endpoint defined for the API');
            }
            return collect();
        }
        $url = self::$sportsdb_base_url . $endpoint;
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->asJson()
            ->get($url);
        if ($response->ok()) {
            $entries = $response->json();
            if ($entries && $entriesIndex && isset($entries[$entriesIndex])) {
                return collect($entries[$entriesIndex]);
            }
            if (config('logging.log_application_warnings')) {
                Log::warning('Empty response from sportsdb API received: ' . $url);
            }
            return collect();
        }
    }

    public function fetchSports(): Collection
    {
        $entries = $this->getApiEntries('all_sports.php', 'sports')->map(function ($entry) {
            return [
                'remote_id' => $entry['idSport'] ?? null,
                'sport_name' => $entry['strSport'] ?? null,
                'image' => $entry['strSportThumb'] ?? null,
            ];
        });
        return $entries;
    }

    public function fetchLeagues(): Collection
    {
        $entries = $this->getApiEntries('all_leagues.php', 'leagues')->map(function ($entry) {
            return [
                'remote_id' => $entry['idLeague'] ?? null,
                'league_name' => $entry['strLeague'] ?? null,
                'sport_name' => $entry['strSport'] ?? null,
            ];
        });
        return $entries;
    }

    public function fetchSingleTeam(int $team_id): Collection
    {
        if (!is_int($team_id) || $team_id <= 0) {
            if (config('logging.log_application_warnings')) {
                Log::warning('Invalid team id used in fetchSingleTeam: ' . $team_id);
            }
            return collect();
        }
        $entries = $this->getApiEntries('lookupteam.php?id=' . $team_id, 'teams')->map(function ($entry) {
            $leagues = [];
            $leagues[] = $entry['idLeague'] ?? null;
            for ($i = 0; $i <= 7; $i++) {
                $leagues[] = $entry['idLeague' . $i] ?? null;
            }
            return [
                'remote_id' => $entry['idTeam'] ?? null,
                'team_name' => $entry['strTeam'] ?? null,
                'image' => $entry['strTeamLogo'] ?? null,
                'stadium_name' => isset($entry['strWebsite']) ? mb_substr($entry['strStadium'], 0, 191) : '',
                'website' => isset($entry['strWebsite']) ? mb_substr($entry['strWebsite'], 0, 191) : '',
                'description' => isset($entry['strDescriptionEN']) ? mb_substr($entry['strDescriptionEN'], 0, 30000) : '',
                'leagues' => collect($leagues)->filter()->unique(),
            ];
        });
        return $entries;
    }

    public function fetchTeams(int $league_id): Collection
    {
        if (!is_int($league_id) || $league_id <= 0) {
            if (config('logging.log_application_warnings')) {
                Log::warning('Invalid league id used in fetchTeams: ' . $league_id);
            }
            return collect();
        }
        $entries = $this->getApiEntries('lookup_all_teams.php?id=' . $league_id, 'teams')->map(function ($entry) {
            $leagues = [];
            $leagues[] = $entry['idLeague'] ?? null;
            for ($i = 0; $i <= 7; $i++) {
                $leagues[] = $entry['idLeague' . $i] ?? null;
            }
            return [
                'remote_id' => $entry['idTeam'] ?? null,
                'team_name' => $entry['strTeam'] ?? null,
                'image' => $entry['strTeamLogo'] ?? null,
                'stadium_name' => isset($entry['strWebsite']) ? mb_substr($entry['strStadium'], 0, 191) : '',
                'website' => isset($entry['strWebsite']) ? mb_substr($entry['strWebsite'], 0, 191) : '',
                'description' => isset($entry['strDescriptionEN']) ? mb_substr($entry['strDescriptionEN'], 0, 30000) : '',
                'leagues' => collect($leagues)->filter()->unique(),
            ];
        });
        return $entries;
    }

    public function fetchStandings(int $league_id): Collection
    {
        if (!is_int($league_id) || $league_id <= 0) {
            if (config('logging.log_application_warnings')) {
                Log::warning('Invalid league id used in fetchStandings: ' . $league_id);
            }
            return collect();
        }
        $entries = $this->getApiEntries('lookuptable.php?l=' . $league_id, 'table')->map(function ($entry) use ($league_id) {
            return [
                'remote_id' => $entry['idStanding'] ?? null,
                'remote_team_id' => $entry['idTeam'] ?? null,
                'remote_league_id' => $entry['idLeague'] ?? $league_id,
                'team_rank' => $entry['intRank'] ?? 0,
                'goals_for' => $entry['intGoalsFor'] ?? 0,
                'goals_against' => $entry['intGoalsAgainst'] ?? 0,
                'goals_difference' => $entry['intGoalsDifference'] ?? 0,
                'wins' => $entry['intWin'] ?? 0,
                'losses' => $entry['intLoss'] ?? 0,
                'draws' => $entry['intDraw'] ?? 0,
                'points' => $entry['intPoints'] ?? 0,
                'season' => $entry['strSeason'] ?? null,
            ];
        });
        return $entries;
    }
}

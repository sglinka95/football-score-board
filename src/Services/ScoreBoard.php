<?php

namespace Sglinka95\FootballScoreBoard\Services;

use Exception;
use Sglinka95\FootballScoreBoard\Models\FootballMatch;
use Sglinka95\FootballScoreBoard\Models\Team;

class ScoreBoard implements ScoreBoardInterface
{
    private array $matches = [];
    public function startGame(Team $homeTeam, Team $awayTeam): FootballMatch
    {
        $id = count($this->matches) + 1;
        $footballMatch = new FootballMatch($id, $homeTeam, $awayTeam);
        $this->matches[$footballMatch->getMatchId()] = $footballMatch;
        return $footballMatch;
    }

    public function finishGame(FootballMatch $footballMatch): bool
    {
        if(isset($this->matches[$footballMatch->getMatchId()])) {
            unset($this->matches[$footballMatch->getMatchId()]);
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function updateScore(FootballMatch $footballMatch, int $homeScore, int $awayScore): bool
    {
        if(isset($this->matches[$footballMatch->getMatchId()])) {
            $match = $this->matches[$footballMatch->getMatchId()];
            if($homeScore < 0) {
                throw new Exception("The value of the variable cannot be less than 0");
            }

            if($awayScore < 0) {
                throw new Exception("The value of the variable cannot be less than 0");
            }

                $homeTeam = $match->getHomeTeam();
                $awayTeam = $match->getAwayTeam();
                $homeTeam->updateScore($homeScore);
                $awayTeam->updateScore($awayScore);
                return true;
        }
        return false;
    }

    public function getSummary(): array
    {
        $this->sortMatches();

        return $this->matches;
    }

    private function sortMatches(): void
    {
        uasort($this->matches, function(FootballMatch $matchA, FootballMatch $matchB) {
            if ($matchA->getTotalScore() === $matchB->getTotalScore()) {
                return $matchB->getMatchId() <=> $matchA->getMatchId();
            }
            return $matchB->getTotalScore() <=> $matchA->getTotalScore();
        });
    }

    public function getMatches(): array
    {
        return $this->matches;
    }

    public function setMatches(array $matches): void
    {
       $this->matches = $matches;
    }
}
<?php

namespace Sglinka95\FootballScoreBoard\Models;

class FootballMatch
{
    const DISPLAY_RESULT_FORMAT = "%s %s - %s %s";
    public function __construct(
        private int $id,
        private Team $homeTeam,
        private Team $awayTeam,
    )
    {
    }

    public function getMatchId(): int
    {
        return $this->id;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function getTotalScore(): int
    {
        return $this->getHomeTeam()->getScore() + $this->getAwayTeam()->getScore();
    }

    public function displayResult(): string {
        return sprintf(
            self::DISPLAY_RESULT_FORMAT,
            $this->getHomeTeam()->getName(),
            $this->getHomeTeam()->getScore(),
            $this->getAwayTeam()->getName(),
            $this->getAwayTeam()->getScore()
        );
    }
}
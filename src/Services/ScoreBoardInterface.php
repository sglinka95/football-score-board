<?php

namespace Sglinka95\FootballScoreBoard\Services;

use Sglinka95\FootballScoreBoard\Models\FootballMatch;
use Sglinka95\FootballScoreBoard\Models\Team;

interface ScoreBoardInterface
{
    public function startGame(Team $homeTeam, Team $awayTeam): FootballMatch;
    public function finishGame(FootballMatch $footballMatch): bool;

    public function updateScore(FootballMatch $footballMatch, int $homeScore, int $awayScore): bool;

    public function getSummary(): array;
    public function getMatches(): array;
    public function setMatches(array $matches): void;


}
<?php

namespace Sglinka95\FootballScoreBoard\Models;

class Team
{
    private int $score;
    public function __construct(
        private string $name
    )
    {
        $this->score = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateScore(int $score): void
    {
        $this->score = $score;
    }

    public function getScore(): int
    {
        return $this->score;
    }

}
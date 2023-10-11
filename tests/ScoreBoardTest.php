<?php

namespace Sglinka95\FootballScoreBoard\Tests;

use PHPUnit\Framework\TestCase;
use Sglinka95\FootballScoreBoard\Models\FootballMatch;
use Sglinka95\FootballScoreBoard\Models\Team;
use Sglinka95\FootballScoreBoard\Services\ScoreBoard;

final class ScoreBoardTest extends TestCase
{
    public function testCreateScoreBoard(): void
    {
        $scoreBoard = new ScoreBoard();
        $this->assertNotNull($scoreBoard->getSummary());
    }

    public function testCreateTeam(): void
    {
        $teamName = "Spain";
        $team = new Team($teamName);
        $this->assertNotNull($team);
        $this->assertEquals($teamName, $team->getName());
    }

    public function testCreateFootballMatch(): void
    {
        $homeTeam = new Team('Spain');
        $awayTeam = new Team('Poland');
        $id = 1;
        $footballMatch = new FootballMatch($id, $homeTeam, $awayTeam);
        $this->assertNotNull($footballMatch);
        $this->assertNotNull($footballMatch->getMatchId());
        $this->assertEquals($awayTeam, $footballMatch->getAwayTeam());
        $this->assertEquals($homeTeam, $footballMatch->getHomeTeam());
    }

    public function testStartAndFinishMatch(): void
    {
        $homeTeam = new Team('Spain');
        $awayTeam = new Team('Poland');
        $scoreBoard = new ScoreBoard();
        $footballMatch = $scoreBoard->startGame($homeTeam, $awayTeam);

        $summary = $scoreBoard->getSummary();
        $this->assertNotEmpty($summary);

        $scoreBoard->finishGame($footballMatch);
        $summary = $scoreBoard->getSummary();
        $this->assertEmpty($summary);
    }

    public function testUpdateScore(): void
    {
        $homeTeam = new Team('Spain');
        $awayTeam = new Team('Poland');
        $scoreBoard = new ScoreBoard();
        $footballMatch = $scoreBoard->startGame($homeTeam, $awayTeam);
        $scoreBoard->updateScore($footballMatch, 0, 1);
        $this->assertEquals(1, $footballMatch->getTotalScore());
        $scoreBoard->updateScore($footballMatch, 1, 1);
        $this->assertEquals(2, $footballMatch->getTotalScore());
        $scoreBoard->updateScore($footballMatch, 2, 1);
        $this->assertEquals(3, $footballMatch->getTotalScore());
        $scoreBoard->finishGame($footballMatch);
    }

    /**
     * @dataProvider scoreInvalidInput
     */
    public function testExceptionWhenScoreInputIsInvalid(int $homeScore, $awayScore): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The value of the variable cannot be less than 0');
        $homeTeam = new Team('Spain');
        $awayTeam = new Team('Poland');
        $scoreBoard = new ScoreBoard();
        $footballMatch = $scoreBoard->startGame($homeTeam, $awayTeam);
        $scoreBoard->updateScore($footballMatch, $homeScore, $awayScore);
        $scoreBoard->finishGame($footballMatch);
    }

    public function testDisplayOrderForSummary(): void
    {
        $matches = $this->generateMatches();
        $scoreBoard = new ScoreBoard();
        $scoreBoard->setMatches($matches);

        $summary = $scoreBoard->getSummary();
        $summaryWithCorrectOrder = $this->summaryWithCorrectOrder();
        foreach ($summaryWithCorrectOrder as $key => $match) {
            $homeTeam = $summary[$key]->getHomeTeam();
            $awayTeam = $summary[$key]->getAwayTeam();
            $displayResult = sprintf(
                '%s %s - %s %s',
                $match["homeTeam"],
                $match["homeScore"],
                $match["awayTeam"],
                $match["awayScore"]
            );
            $this->assertEquals($match["homeTeam"], $homeTeam->getName());
            $this->assertEquals($match["awayTeam"], $awayTeam->getName());
            $this->assertEquals($match["homeScore"], $homeTeam->getScore());
            $this->assertEquals($match["awayScore"], $awayTeam->getScore());
            $this->assertEquals($displayResult, $summary[$key]->displayResult());
        }
    }

    public static function scoreInvalidInput(): array
    {
        return [
            [-1, 0],
            [0, -1],
            [-1, -1]
        ];
    }

    private function generateMatches(): array
    {
        $allMatches = [
            [
                'homeTeam' =>'Mexico',
                'homeScore' => 0,
                'awayTeam' => 'Canada',
                'awayScore' => 5
            ],
            [
                'homeTeam' => 'Spain',
                'homeScore' => 10,
                'awayTeam' => 'Brazil',
                'awayScore' => 2
            ],
            [
                'homeTeam' => 'Germany',
                'homeScore' => 2,
                'awayTeam' => 'France',
                'awayScore' => 2
            ],
            [
                'homeTeam' => 'Uruguay',
                'homeScore' => 6,
                'awayTeam' => 'Italy',
                'awayScore' => 6
            ],
            [
                'homeTeam' => 'Argentina',
                'homeScore' => 3,
                'awayTeam' => 'Australia',
                'awayScore' => 1
            ]
        ];
        $matches = [];
        foreach($allMatches as $key => $match) {
            $id = $key + 1;
            $homeTeam = new Team($match['homeTeam']);
            $awayTeam = new Team($match['awayTeam']);
            $homeTeam->updateScore($match['homeScore']);
            $awayTeam->updateScore($match['awayScore']);
            $matches[$id] = new FootballMatch($id, $homeTeam, $awayTeam);
        }

        return $matches;
    }

    private function summaryWithCorrectOrder(): array
    {
        return [
            4 => [
                'homeTeam' => 'Uruguay',
                'homeScore' => 6,
                'awayTeam' => 'Italy',
                'awayScore' => 6
            ],
            2 => [
                'homeTeam' => 'Spain',
                'homeScore' => 10,
                'awayTeam' => 'Brazil',
                'awayScore' => 2
            ],
            1 => [
                'homeTeam' => 'Mexico',
                'homeScore' => 0,
                'awayTeam' => 'Canada',
                'awayScore' => 5
            ],
            5 => [
                'homeTeam' => 'Argentina',
                'homeScore' => 3,
                'awayTeam' => 'Australia',
                'awayScore' => 1
            ],
            3 => [
                'homeTeam' => 'Germany',
                'homeScore' => 2,
                'awayTeam' => 'France',
                'awayScore' => 2
            ]
        ];
    }
}
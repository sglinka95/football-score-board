<?php
require __DIR__.'/../vendor/autoload.php';

use Sglinka95\FootballScoreBoard\Models\Team;
use Sglinka95\FootballScoreBoard\Services\ScoreBoard;

$scoreBoard = new ScoreBoard();

$homeTeam1 = new Team("Mexico");
$awayTeam1 = new Team("Canada");

$homeTeam2 = new Team("Spain");
$awayTeam2 = new Team("Brazil");

$homeTeam3 = new Team("Germany");
$awayTeam3 = new Team("France");

$homeTeam4 = new Team("Uruguay");
$awayTeam4 = new Team("Italy");

$homeTeam5 = new Team("Argentina");
$awayTeam5 = new Team("Australia");
$footballMatch = $scoreBoard->startGame($homeTeam1, $awayTeam1);
$footballMatch2 = $scoreBoard->startGame($homeTeam2, $awayTeam2);
$footballMatch3 = $scoreBoard->startGame($homeTeam3, $awayTeam3);
$footballMatch4 = $scoreBoard->startGame($homeTeam4, $awayTeam4);
$footballMatch5 = $scoreBoard->startGame($homeTeam5, $awayTeam5);

$scoreBoard->updateScore($footballMatch, 0, 5);
$scoreBoard->updateScore($footballMatch2, 10, 2);
$scoreBoard->updateScore($footballMatch3, 2, 2);
$scoreBoard->updateScore($footballMatch4, 6, 6);
$scoreBoard->updateScore($footballMatch5, 3, 1);
$matches = $scoreBoard->getMatches();
foreach($matches as $match) {
    print_r($match->displayResult() . PHP_EOL);
}
$summary = $scoreBoard->getSummary();
print_r(PHP_EOL);
foreach($summary as $match) {
    print_r($match->displayResult() . PHP_EOL);
}

$scoreBoard->finishGame($footballMatch);
$scoreBoard->finishGame($footballMatch2);
$scoreBoard->finishGame($footballMatch3);
$scoreBoard->finishGame($footballMatch4);
$scoreBoard->finishGame($footballMatch5);
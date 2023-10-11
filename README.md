# Football World Cup Score Board

A PHP library for Football World Cup Score Board

### Requirements
PHP 8 or above and Composer is expected to be installed on our system.

### Installing Composer
For instructions on how to install Composer visit [getcomposer.org](https://getcomposer.org/download/).

### Installing
After cloning this repository, change into the newly created directory and run
```
composer install
```
This will install all dependencies needed for the project.

### Running the Tests

All tests can be run by executing
```
composer test
```

`phpunit` will automatically find all tests inside the `test` directory and run them based on the configuration in the `phpunit.xml` file.

### Usage
See example here [index.php](../main/examples/index.php)
```php
<?php
require __DIR__.'/../vendor/autoload.php';

use Sglinka95\FootballScoreBoard\Models\Team;
use Sglinka95\FootballScoreBoard\Services\ScoreBoard;

$scoreBoard = new ScoreBoard();

$homeTeam1 = new Team("Mexico");
$awayTeam1 = new Team("Canada");

$homeTeam2 = new Team("Spain");
$awayTeam2 = new Team("Brazil");

$footballMatch = $scoreBoard->startGame($homeTeam1, $awayTeam1);
$footballMatch2 = $scoreBoard->startGame($homeTeam2, $awayTeam2);

$scoreBoard->updateScore($footballMatch, 0, 5);
$scoreBoard->updateScore($footballMatch2, 10, 2);

$matches = $scoreBoard->getMatches();
foreach($matches as $match) {
    print_r($match->displayResult() . PHP_EOL);
}

$summary = $scoreBoard->getSummary();
foreach($summary as $match) {
    print_r($match->displayResult() . PHP_EOL);
}

$scoreBoard->finishGame($footballMatch);
$scoreBoard->finishGame($footballMatch2);
```
### Information
The boards support the following operations:

1. Start a game. When a game starts, it should capture (being initial score 0-0)
   * Home team
   * Away Team
2. Finish a game. It will remove a match from the scoreboard.
3. Update score. Receiving the pair score; home team score and away team score
updates a game score
4. Get a summary of games by total score. Those games with the same total score
will be returned ordered by the most recently added to our system.

## License

[MIT](https://choosealicense.com/licenses/mit/)

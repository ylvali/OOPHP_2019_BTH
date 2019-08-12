<?php
namespace Ylva\DiceGame;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../vendor/autoload.php";

// Set up
$aPlayer = new Player();
$aPlayer->setName('Player1');
$aPlayer2 = new Player();
$aPlayer2->setName('Player2');
$aPlayer3 = new Player();
$aPlayer3->setName('Player3');
$aPlayer3->setIsHuman(true);

$nrDice = 6;
$playerArr = [$aPlayer, $aPlayer2, $aPlayer3];



// ::::::::::::::::::::::::::::::: The game ::::::::::::::::::::::::::::::::::


// --- Get current game from session or start a new one ---
if (isset($_SESSION['theGame'])) {
    # Get game session
    $theGame = unserialize($_SESSION["theGame"]);
    $res1 = "Game collected from session";
    $res = $theGame->playGame();

    # Print the players score
    $thePlayersRes = $theGame->getPlayersScore();

    $_SESSION['theGame'] = serialize($theGame);
} else {
    # Start a new game
    $res1 = "New game session: " . strval(rand());
    $theGame = new TheGame($nrDice, $playerArr);
    $firstPlayer = $theGame->getFirstPlayer();
    $res = $theGame->playGame($firstPlayer);
    $_SESSION['theGame'] = serialize($theGame);

    # Print the players score
    $thePlayersRes = $theGame->getPlayersScore();
}


$restartForm = "<button> <a href='destroy_session.php'> New game </a> </button>";

// --- The view ---
# Variables
$title = "Welcome to the Dice Game";

// Render the view, through the template file
require __DIR__ . "/../view/dice/show.php";

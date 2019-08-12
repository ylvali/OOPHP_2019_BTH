<?php
namespace Ylva\DiceGame;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../vendor/autoload.php";


/**
 * Catch the user/computers choice
 * Play again or register points
 *
 * Get the game object from the session & register the necessary
 *
 */

if (isset($_SESSION['theGame'])) {
    # Get game session
    $theGame = unserialize($_SESSION["theGame"]);

    # Get the form arguments
    # If more games are requested, register that in object
    # Save the object in the session
    $playAgain = $_GET['play'];

    if ($playAgain == 'yes') {
        # Set up the object to play again
        $res = $theGame->setPlayAgain();
    } else {
        # Collect points & next player
        $res = $theGame->collectPoints();
        $theGame->nextPlayer();
    }

    # Save the game session
    $_SESSION['theGame'] = serialize($theGame);
}
    # Redirect
    header("location:index.php");

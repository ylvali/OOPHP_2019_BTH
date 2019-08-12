<?php
namespace Ylva\DiceGame;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../vendor/autoload.php";

/**
 * Change player & keep the game going
 */

 // Use the game object & change the player to next one

if (isset($_SESSION['theGame'])) {
     # Get game session
     $theGame = unserialize($_SESSION["theGame"]);

     # Change player to next
     $theGame->nextPlayer();

     # Save the changes
     $_SESSION['theGame'] = serialize($theGame);
}
    # Redirect
    header("location:index.php");

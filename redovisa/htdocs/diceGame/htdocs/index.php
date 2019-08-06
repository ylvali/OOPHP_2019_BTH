<?php
namespace Ylva\DiceGame;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../vendor/autoload.php";

// Set up
$a_dice = new Dice();

// For the view
$title = "Welcome to the Dice Game";

// Render the view, through the template file
require __DIR__ . "/../view/dice/show.php";

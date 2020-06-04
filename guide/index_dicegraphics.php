<?php
/**
* Dice graphic practice
* 2 ways of printing graphics
*
*/

namespace Ylva\Dice;

/**
 * File inclusion
 *
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload_namespace.php");


/**
* Creating an DiceGraphic object
*
*/
$thaDice = new DiceGraphic();


/**
* Throwing the dice
*
* Throw the dice 5 times & save result in a string variable
*/
$times = 5;
$nrs = "";
$graphics = "";
$class = [];

for ($i=0; $i < $times; $i++) {
    $thaDice->throwDice();
    $nr = $thaDice->showDice();
    $nrs .= $nr." ";
    $theGraphic = $thaDice->graphic();
    $graphics .= "<img src='img/dice/".$theGraphic.".png' width=100 alt='graphic'> ";
    $class[] = $thaDice->graphic();
}


/**
* The displaying html
*
*
*/
?>
<!DOCTYPE html>
<html>
<head>
<title> Dice Game </title>
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<h1>Dice Game</h1>
<p><?php echo $nrs ?></p>
<p> Visually way1: <?php echo $graphics ?> </p>
<p class=""> Visually way2:
    <?php foreach ($class as $value) : ?>
        <i class="dice-sprite <?= $value ?>"></i>
    <?php endforeach; ?>
</p>

</body>
</html>

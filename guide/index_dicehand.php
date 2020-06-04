<?php
/**
*
* The dice-hand
*
*/

namespace Ylva\Dice;

/**
 * File inclusion
 *
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload_namespace.php");


$diceHand = new DiceHand();

$dice = $diceHand->theDice();

?>
<!DOCTYPE html>
<html>
<head>
<title> Dice Game </title>
</head>
<body>

<h1>Dice Game</h1>
<h2> The dicehand: </h2>
<p><?php echo $dice ?></p>
<p> The sum: <?php echo $diceHand->theDiceSum()?> </p>
<p> The avg: <?php echo $diceHand->theDiceAvg()?> </p>

</body>
</html>

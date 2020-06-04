<?php
/**
* Test the dice
*
*/


/**
 * File inclusion
 *
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload_namespace.php");



/**
* Display dice
*
*/
$aDice = new \Ylva\Dice\Dice();
$theNrs = "<ul>";
$theNrsArr = [];

for ($i=0; $i<= 5; $i++) {
    $aDice->throwDice();
    $theNr = $aDice->showDice();
    array_push($theNrsArr, $theNr);
    $theNrs .= "<li>".$theNr."</li>";
}
$theNrs.= "</ul>";

$arrLength = count($theNrsArr);

// Calculate the Dice
$nrSum = array_sum($theNrsArr);
$avrg = $nrSum / count($theNrsArr);

?>

<!DOCTYPE html>
<html>
<head>
<title> Dice Game </title>
</head>
<body>

<h1>Dice Game</h1>
<p>.<?php echo $theNrs ?></p>
<p> The sum: <?php echo $nrSum ?> </p>
<p> The avg: <?php echo $avrg ?> </p>

</body>
</html>

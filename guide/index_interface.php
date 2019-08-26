<?php

namespace Ylva\Dice;

/**
 * Show off a histogram.
 */
 require __DIR__ . "/config/config.php";
 require __DIR__ . "/vendor/autoload.php";;


$rolls = $_GET["rolls"] ?? 6;

$dice = new DiceHistogram2();


# Roll dice & save data
for ($i = 0; $i < $rolls; $i++) {
    $dice->roll();
}


# Create a histogram
$histogram = new Histogram();


# Inject the histogram w the data saved in DiceHistogram
# Implementing the specific functionality guaranteed by the interface
$histogram->injectData($dice);


?><h1>Display a histogram</h1>

<p><?= implode(", ", $histogram->getSerie()) ?></p>
<pre><?= $histogram->getAsText() ?></pre>

<?php

namespace Ylva\Dice;

require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";


$rolls = $_GET["rolls"] ?? 6;

$dice = new DiceHistogram();

for ($i = 0; $i < $rolls; $i++) {
    $dice->roll();
}

?><h1>Display a histogram</h1>

<p><?= implode(", ", $dice->getHistogramSerie()) ?></p>
<pre><?= $dice->printHistogram() ?></pre>
<pre><?= $dice->printHistogram(1, 6) ?></pre>

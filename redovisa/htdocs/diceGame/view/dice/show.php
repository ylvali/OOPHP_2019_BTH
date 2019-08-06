<!doctype html>
<meta charset="utf-8">
<title><?= $title ?></title>
<h1><?= $title ?></h1>

<p> The dice has nr: <?= $a_dice->get_dice_nr() ?> </p>

<p> Out of bound : <?= $a_dice->set_dice_nr(8)?> </p>

<?php

/*

  Sdtclass

*/

$object = new stdClass();
var_dump($object);

// Add properties
$object->color = 'purple';
$object->colorSound = function () {
    echo "Hahahahahah";
};

echo ($object->colorSound)(). " " . $object->color;
var_dump($object);

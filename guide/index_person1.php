<?php

// Include necessary files
include("src/Person1.php");

$object = new Person1();
$object->age = 88;
$object->name = "MegaMe";

echo $object->details();
var_dump($object);

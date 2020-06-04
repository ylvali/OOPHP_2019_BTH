

<?php
/**
 * Show off the autoloader.
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

$object = new Person4("MegaMic", 42);
echo $object->details();
var_dump($object);

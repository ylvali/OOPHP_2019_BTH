<?php

/**
 * Show off the autoloader using namespace.
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload_namespace.php");

$object = new \Ylva\Person\Person("MegaMic", 42);
echo $object->details();
var_dump($object);

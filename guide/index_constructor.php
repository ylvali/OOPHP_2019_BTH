<?php
/*
*
* A test for the constructors
*
*
*/

// Include necessary files
include("src/Person4.php");

$person4 = new Person4('Strong Woman', 33);
$personTest = new Person4();

var_dump($person4);
var_dump($personTest);

<?php
/*
*
* A test for setters and getters
*
*
*/

// Include necessary files
include("src/Person3.php");

// Initiate the obejct from the class
$pObject = new Person3();

// Read the object details
echo $pObject->details();

// Set an age
$pObject->setAge(33);

// Get the age
echo $pObject->getAge();

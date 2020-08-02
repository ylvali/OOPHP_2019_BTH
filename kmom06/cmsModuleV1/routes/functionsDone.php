<?php

// Create a coma seperated string
function stringFromArr(array $theArr) {
    $theString = "";
    foreach ($theArr as $key => $value) {
        if (!is_numeric($value)) {
            $theString .= "$value,";
        }
    }
    $theString = rtrim($theString, ","); // remove last coma

    return $theString;
}

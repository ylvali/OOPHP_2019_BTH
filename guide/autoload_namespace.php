<?php
/**
* Autoloader ::: classes w namespace
* The vendor (deliverer) name is exluded
*
* @param string $class : it is the name of the class.
*
*/

spl_autoload_register(function ($class) {
  //echo "$class<br>";

    // Base directory for the namespace prefix
    $baseDir = __DIR__."/src/";

    //echo "$baseDir<br>";

    // Remove vendor part
    $offset = strpos($class, "\\") + 1;
    //echo "$offset <br>";

    // Get relative class name
    $relativeClass = substr($class, $offset);
    //  echo "$relativeClass <br>";

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace("\\", "/", $relativeClass) . '.php';
    //echo "$file <br>";

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

<?php
namespace Ylva\ProductDb;

require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";
//require __DIR__ . "/src/Example/Database.php";


// Connect to the database
$db = new Database();
$db->connect($databaseConfig);

// Collect from the db
$sql = "SELECT * FROM test;";
$resultset = $db->executeFetchAll($sql);

var_dump($resultset);

echo 'test';

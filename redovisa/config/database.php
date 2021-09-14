<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite:memory::",
 *
 */

 // // "dsn"              => "mysql:host=blu-ray.student.bth.se:3306;dbname=ylsj11",
 // "dsn"              => "mysql:localhost;dbname=oophp",
 // // "username"         => 'ylsj11',
 // "username"         => 'user',
 // // "password"         => 'c3wARF3zGpfX',
 // "password"         => 'pass',


return [
    // "dsn"              => "mysql:host=localhost;dbname=oophp",
    "dsn"              => "mysql:host=blu-ray.student.bth.se:3306;dbname=ylsj11",
    // "username"         => 'user',
    "username"         => 'ylsj11',
    // "password"         => 'pass',
    "password"         => 'c3wARF3zGpfX',
    "driver_options"   => null,
    "fetch_mode"       => \PDO::FETCH_OBJ,
    "table_prefix"     => null,
    "session_key"      => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => false,
];

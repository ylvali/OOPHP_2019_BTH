<?php
/**
 *   Reset database
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/


// $file   = "proDb/reset.sql";
// $mysql  = "/usr/share/mysql";
// $host = '127.0.0.1';
// $user = 'user';
// $pass = 'pass';
// $db = 'oophp';
//
// $command = "$mysql -h{$host} -u{$user} -p{$pass} $db < $file 2>&1";
// $output = [];
// $status = null;
// $res = exec($command, $output, $status);
// $output = "<p>The command was: <code>$command</code>.<br>The command exit status was $status."
//     . "<br>The output from the command was:</p><pre>"
//     . print_r($output, 1);
//
// var_dump($output);


// Reset the database
$resetFile = __DIR__.'/resetDbSql.php';
$db->anaxOn = false;
$project->reset($resetFile);
$db->anaxOn = true;
$res = 'The database was reset';
$btnPanel = "<a href=''> Show all products </a>";
$nrPages = '';

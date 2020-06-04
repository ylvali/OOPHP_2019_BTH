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

// Reset the database
$resetFile = __DIR__.'/../db/reset.php';
$project->reset($resetFile);
$res = 'The database was reset';
$btnPanel = "<a href=''> Show all </a>";
$nrPages = '';

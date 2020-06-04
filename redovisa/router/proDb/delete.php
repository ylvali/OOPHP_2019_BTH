<?php
/**
 *   Delete
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

// Delete from database

$delete = $option[1];
$res = "Id $delete deleted";
// var_dump('testin');
$btnPanel = "<a href=''> Show all products</a>";
$table = 'products';
$column = 'id';
$id = $delete;
$project->deleteItem($table, $column, $id);
$nrPages = '';

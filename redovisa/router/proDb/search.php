<?php
/**
 *   Search products
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

$searchWord = $sendVar->postValue('searchWord');
if ($searchWord) {
    $table = 'products';
    $column = array('id', 'name', 'year');
    $res = $project->searchMultipleColumns($table, $column, $searchWord);
    $btnPanel = "<a href=''> Show all </a>";
}
$btnPanel = "<a href=''> Show all products</a>";
$nrPages = '';

<?php
/**
 *   Edit
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

// Edit in the database
    // var_dump($edit);
    $table = 'products';
    $column = 'id';
    $id = $option[1];
    $form = $project->updateForm($table, $column, $id);
    $res = $form;
    // var_dump('testin');
    $btnPanel = "<a href=''> Show all products</a>";
    $nrPages = '';

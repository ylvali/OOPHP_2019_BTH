<?php
/**
 *   Show all products
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/


/* Security Control of values */

//  nrItems
// Should be set & numeric
if (!isset($nrItems) || !is_numeric($nrItems)) {
    $nrItems = 4;
}

// nrPages
// Should be set and positive
if (!isset($nrPages) || $nrPages < 0) {
    $nrPages = 1;
}

// orderBy & order
// Should be certain strings
$columns = ["id", "name", "year"];
$orders = ["asc", "desc"];

if ($orderBy && $order) {
    if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
         // die("Not valid input for sorting.");
        // $res = "Not valid sorting variables";
        $orderBy = null;
        $order = null;
    }
};

/* Calculation  */

// Calculate the nr of pages
$idVar = 'id';
$table = 'products';
$pageLink = $project->getNrPages($idVar, $table, $nrItems, $settings, $nrPages);

// Calculate the offset value
$startAt = (intval($nrPages) - 1) * intval($nrItems);

/* Final result */
// var_dump($settings);
$t = $table;
$n = $nrItems;
$s = $startAt;
$oB = $orderBy;
$o = $order;
$set = $settings;
$res = $project->displaySelected($t, $n, $s, $oB, $o, $set);

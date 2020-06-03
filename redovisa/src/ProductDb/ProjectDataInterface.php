<?php
/**
 *   ProjectDataInterface
 *   php version 7
 *  Determines what the ProjectData must include
 *
 * @category ProjectData
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

 namespace Anax\ProductDb;

/**
 * ProjectDataInterface is the interface for the project specific data
 *
 * @category ProjectData
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 */

interface ProjectDataInterface
{
    /**
     * Collects value from $_POST
     *
     * @param $resArray : array of data
     *
     * @return string $var : the string table of the array for ui
     */
    public function getStringTable($resArray);
}

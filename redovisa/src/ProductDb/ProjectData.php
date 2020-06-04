<?php
/**
 *   ProjectData
 *   php version 7
 *  The data for the specific project
 *
 * @category ProjectData
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
namespace Anax\ProductDb;

use Exception;

/**
 * ProjectData handles all the project specific data
 *
 * @category ProjectData
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class ProjectData implements ProjectDataInterface
{
     use TablePrintTrait;

    /**
     * Constructor to initiate the project
     */
    public function __construct()
    {
    }
}

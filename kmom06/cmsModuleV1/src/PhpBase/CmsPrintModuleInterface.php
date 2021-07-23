<?php
/**
 *  CmsPrintModuleInterface
 *  php version 7
 *
 * @category CmsPrintModuleInterface
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\PhpBase;
use PDO;
use Exception;

/**
 *  CmsPrintModuleInterface
 *  CmsPrintModuleInterface is the interface for the CmsModule.
 *  It prints the result in a project specific way
 *  Printing tailored to suit
 *
 *  Php version 7
 *
 * @category CmsPrintModuleInterface
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

interface CmsPrintModuleInterface
{
    /**
     * The printPage
     * prints a page - project specific data
     *
     * @param array $data : the data for printing
     *
     * @return string: $res : the formated result
     */
    public function printPage($data);


    /**
     * The printBlog
     * prints a page - project specific data
     *
     * @param array $data : the data for printing
     *
     * @return string: $res : the formated result
     */
    public function printBlog($data);

}

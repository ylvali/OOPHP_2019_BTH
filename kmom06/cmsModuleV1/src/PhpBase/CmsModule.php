<?php
/**
 *  cmsModule
 *  php version 7
 *  The cms module
 *
 * @category CmsModule
 * @package PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
namespace Ylva\PhpBase;
use Exception;

/**
 *   CmsModule
 *   php version 7
 *   The cmsModule enables cms
 *   It depends on the interface for DbCrud
 *   It is injected with the CmsPrintModule for printing
 *
 * @category CmsModule
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class CmsModule
{
    /**
     * CmsModule enables Cms for a project
     *
     * @var object $dbConnection   The DbCrud class
     *
     */

    public $dbConnection; // The database PDO connection from DbCrud

    /**
     * Constructor to initiate db connection
     *
     * @param object $theDb   - the dbCrud class interface
     * @param object $thePrinter   - the dbCrud class interface
     *
     */
    public function __construct(
        DbCrudInterface $theDb,
        CmsPrintModuleInterface $printM) {

        // Save database connection as property
        $this->dbConnection = $theDb;

        // Save printer
        $this->thePrinter = $printM;
    }

        /** THE PAGE **/

        /**
         * Read the page : data for a single page
         *
         * @param string $tableName  : the table
         * @param string $orderBy    : which column
         * @param string $order      : which order
         *
         * @return array
         */
        public function readPage($tableName, $orderBy = null, $order = null)
        {
            $res = $this->dbConnection->read($tableName, $orderBy, $order);

            $printedData = $this->thePrinter->printPage($res);

            return $printedData;
        }

        /**
         * The page updater : update page
         *
         * @param string $table            : which table to use
         * @param array $params            : (columnName => newValue)
         * @param string $identifyingVar   : identifying variable
         * @param string $identifyingValue : identifying value
         *
         * @return string $updated values
         */
        public function updatePage($table, $params, $identifyingVar, $identifyingValue)
        {
            $res = $this->dbConnection->update($table, $params, $identifyingVar, $identifyingValue);

            $printedData = $this->thePrinter->printBlog($res);

            return $printedData;
        }


        /** THE BLOG **/

        /**
         * Create blog
         * Method for creating new item in database
         * Creates a new item from sql
         *
         * @param string $table  : which table to use
         * @param array  $params : (columnName => newValue)
         *
         * @return string $res : the result returned
         */
        public function createBlog($table, $params)
        {
            $res = $this->dbConnection->create($table, $params);

            $printedData = $this->thePrinter->printBlog($res);

            return $printedData;
        }


        /**
         * Read blog : blog data
         *
         * @param string $tableName  : the table
         * @param string $orderBy    : which column
         * @param string $order      : which order
         *
         * @return array
         */
        public function readBlog($tableName, $orderBy = null, $order = null)
        {
            $res = $this->dbConnection->read($tableName, $orderBy, $order);

            $printedData = $this->thePrinter->printBlog($res);

            return $printedData;
        }


        /**
         * The blog updater : update blog
         *
         * @param string $table            : which table to use
         * @param array $params            : (columnName => newValue)
         * @param string $identifyingVar   : identifying variable
         * @param string $identifyingValue : identifying value
         *
         * @return string $updated values
         */
        public function updateBlog($table, $params, $identifyingVar, $identifyingValue)
        {
            $res = $this->dbConnection->update($table, $params, $identifyingVar, $identifyingValue);

            $printedData = $this->thePrinter->printBlog($res);

            return $printedData;
        }


}

<?php
/**
 *  CmsModule
 *  php version 7
 *  The cms module
 *
 * @category CmsModule
 * @package  PhpBase
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
 *   Plugin with different database tables & print options.
 *   The reference params to direct to the correct printer method.
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
     */

    private $dbConnection; // The database PDO connection from DbCrud
    private $thePrinter; // The CmsPrintModule

    /**
     * Constructor to initiate db connection
     *
     * @param object $theDb  - the dbCrud class interface
     * @param object $printM - the dbCrud class interface
     */
    public function __construct(
        DbCrudInterface $theDb,
        CmsPrintModuleInterface $printM
    ) {

        // Save database connection as property
        $this->dbConnection = $theDb;

        // Save printer
        $this->thePrinter = $printM;
    }


    /* PRINT */

    /**
     * Print : print the data
     * The reference directs to correct printer option.
     *
     * @param array  $dataArr : the data array
     * @param string $ref     : the reference
     * @param string $other   : other data
     *
     * @return string            : the result
     */
    private function print($dataArr, $ref, $other=null)
    {
        // Router for the data
        switch ($ref) {
        case "page":
            $data = $this->thePrinter->printPage($dataArr);
            break;
        case "blog":
            $data = $this->thePrinter->printBlog($dataArr);
            break;
        case "blogAdmin":
            $data = $this->thePrinter->printBlogAdmin($dataArr);
            break;
        case "theForm":
            $data = $this->thePrinter->printForm($dataArr, $other);
            break;
        case "noPrint":
            $data = $dataArr;
            break;
        default:
            $data = $this->thePrinter->printPage($dataArr);
        }
        return $data;
    }


    /* CREATE */

    /**
     * Create
     * Method for creating new item in database
     * Creates a new item from sql
     *
     * @param string $table  : which table to use
     * @param array  $params : (columnName => newValue)
     *
     * @return string $res : the result returned
     */
    public function create($table, $params)
    {
        $res = $this->dbConnection->create($table, $params);

        return $res;
    }

    /**
     * CreateForm
     * Method for creating a form
     * Creates a new item from sql
     *
     * @param string $formAction : the form action
     *
     * @return string $res : the result returned
     */
    public function createForm($formAction)
    {
        $data = $this->thePrinter->createForm($formAction);

        return $data;
    }


    /* READ */

    /**
     * Read : read all the data
     *
     * @param string $tableName : the table
     * @param string $ref       : the print reference
     * @param string $orderBy   : which column
     * @param string $order     : which order
     *
     * @return array
     */
    public function read($tableName, $ref, $orderBy = null, $order = null)
    {
        $res = $this->dbConnection->read($tableName, $orderBy, $order);

        $data = $this->print($res, $ref);

        return $data;
    }


    /* SEARCH */

    /**
     * Search : search for a value and print
     *
     * @param string  $tableName   : the table
     * @param string  $column      : the column name (ex id)
     * @param string  $searchValue : the value searched for (ex 1)
     * @param boolean $exactVal    : if to search exact / %included%
     * @param string  $ref         : the printing option
     *
     * @return array
     */
    public function search(
        $tableName, $column, $searchValue, $exactVal = false, $ref
    ) {
        $res = $this->dbConnection
            ->search($tableName, $column, $searchValue, $exactVal);

        $data = $this->print($res, $ref, $tableName);

        return $data;
    }



    /* THE uPDATE */

    /**
     * The updater
     *
     * @param string $table            : which table to use
     * @param array  $params           : (columnName => newValue)
     * @param string $identifyingVar   : identifying variable
     * @param string $identifyingValue : identifying value
     *
     * @return string $updated values
     *
     * UPDATE $table SET $key = ? WHERE $identifyingVar = '$identifyingValue';
     */
    public function update($table, $params, $identifyingVar, $identifyingValue)
    {
        $res = $this->dbConnection
            ->update($table, $params, $identifyingVar, $identifyingValue);

        return $res;
    }


    /* THE DELETE */

    /**
     * The deleter : complete delete
     *
     * @param string $table   : which table to use
     * @param string $column  : which column
     * @param string $idValue : identifying value of what will be deleted
     *
     * @return string $updated values
     */
    public function delete($table, $column, $idValue)
    {
        $res = $this->dbConnection->delete($table, $column, $idValue);

        return $res;
    }


    /**
     * The softDeleter : changes status to deleted, not really deleting
     *
     * @param string $table   : which table to use
     * @param string $idVar   : identifying variable
     * @param string $idValue : identifying value
     *
     * @return string $updated values
     */
    public function softDelete($table, $idVar, $idValue)
    {
         $params= array('deleted' => date("Y-m-d H:i:s"));

         $res = $this->dbConnection
             ->update($table, $params, $idVar, $idValue);

        return $res;
    }


    /**
     * SLugify by Mos
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }


    /**
     * IsEmpty
     * Check if a search is empty
     *
     * @param string  $table      : which table to use
     * @param string  $column     : which column to use
     * @param string  $searchWord : which searched word
     * @param boolean $exactWord  : set to true when searching an exact word
     *                            and not just %included%
     *
     * @return boolean $res       : the result
     */
    public function isEmpty(
        $table, $column, $searchWord, $exactWord = false
    ) {

            $res = $this->dbConnection->isEmpty(
                $table, $column, $searchWord, $exactWord = false
            );

            return $res;
    }
}

<?php
/**
 *  cmsModule
 *  php version 7
 *  The cms module
 *
 * @category CmsPrintModule
 * @package PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
namespace Ylva\PhpBase;
use Exception;

/**
 *   CmsPrintModule
 *   php version 7
 *   The cmsPrintModule that prints data from the cmsModule
 *
 * @category CmsPrintModule
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class CmsPrintModule implements CmsPrintModuleInterface
{
    /**
     * CmsModule enables printing Cms for a project
     * Project specific tailoring prints to the data
     */

    /**
     * Constructor to initiate cms printer
     *
     */
    public function __construct() {


    }


        /**
         * Print data : project specific
         *
         * @param array $pageArr        : the data array
         *
         * @return string $printedData : return the printed data
         */

        public function printPage($data)
        {
            // var_dump($resArray);
            // Create a table from the results
            $pageDisplay = "<div id= 'pDisp'>";
            foreach ($data as $row) {
                $pageDisplay .= "<h2> {$row->title} </h2>";
                $pageDisplay .= "<p>{$row->data}</p>";
            }
               $pageDisplay .= "</div>";

            return $pageDisplay;
        }


        /**
         * Print data : project specific
         *
         * @param array $pageArr        : the data array
         *
         * @return string $printedData : return the printed data
         */

        public function printBlog($data)
        {

        // Create a table from the results
        $table = "<table class='tableStyle1'>
                    <tr>
                        <th> <h1> The Blog </h1> </th>
                        <th>Title </th>
                        <th>Data </th>
                        <th>Published </th>
                        <th>See full page</th>
                        <th><br/></th>

                    </tr>";
        foreach ($data as $row) {
                $table .= " <tr> ";
                $table .= "<td>{$row->title}</td>";
                $table .= "<td>{$row->data}</td>";
                $table .= "<td>{$row->published}</td>";
                $table .= "<td><a href='/?see={$row->slug}'> See full </a></td>";
        }
            $table .= "</table>";

        return $table;
    }
}

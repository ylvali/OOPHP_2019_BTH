<?php
/**
 *  CmsModule
 *  php version 7
 *  The cms module
 *
 * @category CmsPrintModule
 * @package  PhpBase
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
     */
    public function __construct()
    {
    }

    /**
     * Print data : project specific
     *
     * @param array $data : the data array
     *
     * @return string $pageDisplay : return the printed data
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
     * @param array $data : the data array
     *
     * @return string $printedData : return the printed data
     */
    public function printBlog($data)
    {
        // Create a table from the results
        $table = "<table class='tableStyle1'>
                    <tr>
                        <th>Title </th>
                        <th>Data </th>
                        <th>Published </th>
                        <th>See full page</th>
                        <th><br/></th>

                    </tr>";
        foreach ($data as $row) {

            if ($row->deleted == null) {
                    $table .= " <tr> ";
                    $table .= "<td>{$row->title}</td>";
                    $table .= "<td>{$row->data}</td>";
                    $table .= "<td>{$row->published}</td>";
                if ($row->slug) {
                        $table .= "<td><a href='?route=full&&see=$row->slug'>
                         See full </a></td>";
                }
            }
        }
            $table .= "</table>";

        return $table;
    }

    /**
     * PrintBlogForm : project specific - blog
     *
     * @param array  $data      : the data
     * @param string $tableName : the data
     *
     * @return string $printedData : return the printed data
     */
    public function printForm($data, $tableName)
    {
        // Create a form from the results
        $form = "<form action='?route=form&&sub=$tableName' method='post'>";
        foreach ($data as $row) {
                $form .= "<input type='hidden'id='id' name='id'
                value={$row->id}></br>";
                $form .= "<label for='title'>Title</label></br>";
                $form .= "<input type='text' class='txtField1' id='title'
                name='title' value='{$row->title}'></br>";
                $form .= "<label for='data'>Data</label></br>";
                $form .= "<textarea id='data' name='data' rows='5' cols='60'>
                {$row->data}
                </textarea>";
        }
            $form .= "<button name='update' class='btn1' type='submit
            ' value='update'>update</button>";
            $form .= "</form>";

        return $form;
    }

    /**
     * CreateForm : project specific - create blog form
     *
     * @param array $formAction : the form action
     *
     * @return string $form : return the printed data
     */
    public function createForm($formAction)
    {
        // Create a form from the results
        $form = "<form action='$formAction' method='post'>
                 <label for='title'>Title</label></br>
                 <input type='text' class='txtField1' id='title'
                 name='title' value=''>
                 <label for='data'>Data</label></br>
                 <textarea id='data' name='data' rows='5' cols='60'>
                 </textarea>
                 <button name='update' class='btn1' type='submit
                 'value='update'> Create </button>";

        return $form;
    }


    /**
     * PrintBlogEdit - Print blog table with edit option
     *
     * @param array $data : the data array
     *
     * @return string $printedData : return the printed data
     */
    public function printBlogAdmin($data)
    {
        // Create a table from the results
        $table = "<table class='tableStyle1'>
                    <tr>
                        <th>Title </th>
                        <th>Data </th>
                        <th>Published </th>
                        <th>Created </th>
                        <th>updated </th>
                        <th>Deleted </th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>See full page</th>
                        <th><br/></th>
                    </tr>";

        foreach ($data as $row) {
                $table .= " <tr> ";
                $table .= "<td>{$row->title}</td>";
                $table .= "<td>{$row->data}</td>";
                $table .= "<td>{$row->published}</td>";
                $table .= "<td>{$row->created}</td>";
                $table .= "<td>{$row->updated}</td>";
                $table .= "<td>{$row->deleted}</td>";
                $table .= "<td><a href='
                ?route=edit&&sub=blog&&id={$row->id}'> Edit </a>";
                $table .= "<td><a href='
                ?route=delete&&sub=blog&&id={$row->id}'> Delete </a></td>";
            if ($row->slug) {
                    $table .= "<td><a href='
                    ?route=full&&see=$row->slug'> See full </a></td>";
            }
        }
            $table .= "</table>";

         return $table;
    }
}

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
 *  The cmsPrintModule that prints data from the cmsModule.
 *  It also santizises all data for the printng.
 *  It is project specific & hard coded that way, with an easy to
 *  update structure.
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
     * Sanitizes according to the database structure
     * Prints texts with text filters
     *
     * @param object $txtFilter : text filters for printing
     *
     */

     private $txtFilters;

    /**
     * Constructor to initiate cms printer
     *
     * @param object $txtFilter : text filters for printing
     */
    public function __construct(TheTextFilterInterface $filters)
    {
        $this->txtFilter = $filters;
    }

    /**
     * Sanitize data : sanitize the incoming dat
     * PDO object printing, according to database structure
     * A routes can directs the data to the correct sanitation
     *
     * @param array $data : the data array
     *
     * @return string $data : return the sanitized data
     */
    public function sanitize($data)
    {
        // Page sanitation of data edited by the users
        foreach ($data as $row) {
                $row->title = strip_tags(htmlentities($row->title));
                $row->data = strip_tags(htmlentities($row->data));
        }

        return $data;
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
        // Sanitize the data
        $data = $this->sanitize($data);

        // Create a html display
        $pageDisplay = "<div id= 'pDisp'>";
        foreach ($data as $row) {

            // Filter data
            $data = $this->txtFilter
            ->parse($row->data, explode(",", $row->filter));

            $pageDisplay .= "<h2> $row->title </h2>";
            $pageDisplay .= "$data";
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
        // Sanitize the data
        $data = $this->sanitize($data);

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

                    var_dump($row->filter);

                    // Filter data
                    $data = $this->txtFilter
                    ->parse($row->data, explode(",", $row->filter));

                    // Create a data table
                    $table .= " <tr> ";
                    $table .= "<td>$row->title</td>";
                    $table .= "<td>$data</td>";
                    $table .= "<td>$row->published</td>";

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
        // Sanitize the data
        $data = $this->sanitize($data);

        // Create a form from the results
        $form = "<form action='?route=form&&sub=$tableName' method='post'>";
        foreach ($data as $row) {
                $form .= "<input type='hidden'id='id' name='id'
                value={$row->id}></br>";
                $form .= "<label for='title'>Title</label></br>";
                $form .= "<input type='text' class='txtField1' id='title'
                name='title' value='{$row->title}'></br>";
                if (isset($row->path)) {
                    $form .= "<label for='title'>Path</label></br>";
                    $form .= "<input type='text' class='txtField1' id='path'
                    name='path' value='{$row->path}'></br>";
                } else {
                    $form .= "<label for='title'>Path</label></br>";
                    $form .= "<input type='text' class='txtField1' id='path'
                    name='path' value=''></br>";
                }
                $form .= "<label for='data'>Data</label></br>";
                $form .=
                "<textarea id='data' name='data' rows='5' cols='60'>{$row->data}
                </textarea> <br/>";
        }
            // Filters
            $form .= "<label for='filers'>Filters</label></br>
            <input type='checkbox' id='bbcode' name='bbcode' value='bbcode'>
            <label for='bbcode'>bbcode</label></br>

            <input type='checkbox' id='link' name='link' value='link'>
            <label for='link'>link</label></br>

            <input type='checkbox' id='markdown' name='markdown' value='markdown'>
            <label for='markdown'>markdown</label></br>

            <input type='checkbox' id='nl2br' name='nl2br' value='nl2br'>
            <label for='nl2br'>nl2br</label></br>";

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
                 name='title' value=''> <br/>

                 <label for='title'>Path</label></br>
                 <input type='text' class='txtField1' id='path'
                 name='path' value=''> <br/>

                 <label for='data'>Text</label></br>
                 <textarea id='data' name='data' rows='5' cols='60'>
                 </textarea><br/><br/>

                 <label for='filers'>Filters</label></br>
                 <input type='checkbox' id='bbcode' name='bbcode' value='bbcode'>
                 <label for='bbcode'>bbcode</label></br>

                 <input type='checkbox' id='link' name='link' value='link'>
                 <label for='link'>link</label></br>

                 <input type='checkbox' id='markdown' name='markdown' value='markdown'>
                 <label for='markdown'>markdown</label></br>

                 <input type='checkbox' id='nl2br' name='nl2br' value='nl2br'>
                 <label for='nl2br'>nl2br</label></br>

                 <button name='create' class='btn1' type='submit'
                 value=''> Create </button>";

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
        // Sanitize the data
        $data = $this->sanitize($data);

        // Create a table from the results
        $table = "<table class='tableStyle1'>
                    <tr>
                        <th>Title </th>
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
                // $table .= "<td>{$row->data}</td>";
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

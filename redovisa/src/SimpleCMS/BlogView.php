<?php
/**
 *  BlogView
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PDO;
use Exception;
use PDOException;

// Disabling phpcs because of private methods needing underscore.
// Which phpmd says is not CamelCase
// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore
// phpcs:disable PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore


/**
 *  BlogView
 *  php version 7
 *  Creates the view in html from PDO obj
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT yso@spektatum.com
 * @link     MIT yso@spektatum.com
 **/

class BlogView
{
    /**
     * Blog
     *
     * @var object $dbc    The database class
     * @var object $filter Text filter
     */


    public $dbC; // The database connection, dbCrud object
    private $filter; // The text filter

    /**
     * Constructor to initiate the object
     *
     * @param object $textFilter : the text filter class
     *
     * @return void
     */
    public function __construct(TheTextFilterInterface $textFilter)
    {
        $this->filter = $textFilter;
    }


    /**
     * Display all blogs
     *
     * @param object $pdoRes : the pdo object w blog result
     *
     * @return string $htmlString
     */
    public function printHTML($pdoRes)
    {
        // Sanitize the data
        $pdoRes = $this->sanitize($pdoRes);

        $table = "<table>";
        $table .= "<tr>";
        $table .= "<th>";
        $table .= "Id";
        $table .= "</th>";
        $table .= "<th>";
        $table .= "Title";
        $table .= "</th>";
        $table .= "<th>";
        $table .= "Path";
        $table .= "</th>";
        $table .= "<th>";
        $table .= "Slug";
        $table .= "</th>";
        $table .= "<th>";
        $table .= "Data";
        $table .= "</th>";
        $table .= "<th>";
        $table .= "Status";
        $table .= "</th>";
        // $table .= "<th>";
        // $table .= "Updated";
        // $table .= "</th>";
        // $table .= "<th>";
        // $table .= "Deleted";
        // $table .= "</th>";
        $table .= "<th>";
        $table .= "Action";
        $table .= "</th>";
        $table .= "</tr>";


        try {
            foreach ($pdoRes as $entity) {
                $theId = $entity->id;
                $form = $this->getActionForm($theId);

                $path = $entity->path;
                $slug = $entity->slug;
                // $slug = $entity->slug;
                $title = $entity->title;
                $data = $entity->data;
                // $type = $entity->type;
                // $published = $entity->published;
                $created = $entity->created;
                $updated = $entity->updated;
                $deleted = $entity->deleted;
                $filters = $entity->filter;

                // Create text filter array
                $arrFilters = explode(',', $filters);

                // Filter the data
                $data = $this->filter->parse($data, $arrFilters);

                $table .= "<tr>";
                $table .= "<td> $theId </td>";
                $table .= "<td> <h1> $title </h1> </td>";
                $table .= "<td> $path </td>";
                $table .= "<td> $slug </td>";
                $table .= "<td> $data </td>";
                $table .= "<td> Created : $created <br/>";
                $table .= "     Updated : $updated <br/>";
                $table .= "     Deleted: $deleted </td>";
                $table .= "<td> $form </td>";
                $table .= "</tr>";
            }
        } catch (\Exception $e) {
            return false;
        }

        $table .= "</table>";

        return $table;
    }


    /**
     * Form for delete / edit
     *
     * @param string $theId : the nr of pages
     *
     * @return string $form
     */
    private function getActionForm($theId)
    {
        $form = "<form action='' method='post'>
                <input type='hidden' name='theIdVal' value='$theId'>
                <input type='submit' class='btn1'
                name='pageSection' value='edit'><br/>
                <input type='submit' class='btn1'
                name='pageSection' value='soft_delete'>
                <input type='submit' class='btn1'
                name='pageSection' value='db_delete'>
                </form>
                ";
        return $form;
    }


    /**
     * Form for editing
     * Settings the right data from the pdo object
     *
     * @param string $theId  : the nr of page
     * @param string $pdoObj : the pdo obj with project data
     *
     * @return mixed string form or boolean false
     */
    public function getEditForm($theId, $pdoObj)
    {
        try {
            foreach ($pdoObj as $entity) {
                $path = $entity->path;
                $title = $entity->title;
                $data = $entity->data;
            }
        } catch (\Exception $e) {
            return false;
        }

        $form = "<form action='' method='post'>
                <input type='hidden' name='theIdVal' value='$theId'>
                <input type='hidden' name='pageSection' value='newEditValues'>
                <input type='text' name='title' value='$title'><br/>
                <input type='text' name='path' value='$path'><br/>
                <textarea name='data' rows='4' cols='50'>$data</textarea><br/>
                <br/><input type='submit' name='' class='btn1' value='edit'>
                </form>
                ";

        return $form;
    }


    /**
     * CreateForm : project specific - create blog form
     *
     * @return string $form : return the printed data
     */
    public function getCreateForm()
    {
        // Create a form from the results
        $form = "<form action='' method='post'>
                 <input type='hidden' name='pageSection' value='new'>

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

                 <input type='checkbox' id='markdown'
                 name='markdown' value='markdown'>
                 <label for='markdown'>markdown</label></br>

                 <input type='checkbox' id='nl2br' name='nl2br' value='nl2br'>
                 <label for='nl2br'>nl2br</label></br>

                 <button name='create' class='btn1' type='submit'
                 value=''> Create </button>";

        return $form;
    }


    /**
     * Display page buttons
     *
     * @param int    $nrPages  : the nr of pages
     * @param int    $thisPage : the current Pag
     * @param object $settings : settings STD object memory
     *
     * @return string $pageBtns
     */
    public function pageButtons($nrPages, $thisPage = 1, $settings = null)
    {

        if (!$settings) {
            $settings = '{"orderBy":"id","order":"desc","nrItems":"4","pageNr":"1"}';
            $settings = json_decode($settings); // Decode to STD object
        }

        // Try getting the nr Pages, no crash if not set
        try {
            $thisPage = $settings->pageNr;
        } catch (\Exception $e) {
            $thisPage = 1;
        }

        // Encode memory to JSON to send with the form
        $settings = json_encode($settings); // Send as JSON memory

        $form = "<form action='' method='post'>";
        $form .= "<input type='hidden' class='btn1'
                  name='settings' value=$settings>";
        $form .= "<input type='hidden' class='btn1'
                  name='pageSection' value='blog'>";
        $form .= "<h3>Page Nr:</h3>";
        for ($i=0; $i<$nrPages; $i++) {
            $aNr = $i + 1;
            // $pages .= "<a href=?nrPages=$aNr>| $aNr |</a>";

            // Set the btn class style
            $class = 'btn1';
            if ($aNr == $thisPage) {
                $class = 'btn1Selected';
            }

            // Create the btn
            $form .= "<button type=submit class='$class' name='pageNr'";
            $form .= " value=$aNr> $aNr </button>";
        }

        $form .="<br/><br/><h3>Items per page:</h3>";
        $form .="<input type='submit' class='btn1' name='nrItems' value=2>";
        $form .= "<input type='submit' class='btn1' name='nrItems' value=4>";
        $form .= "</form>";

        return $form;
    }


      /**
       * Sanitize data : sanitize the incoming data
       * PDO object printing, according to database structure
       *
       * SANITIZE: https://www.php.net/manual/en/function.htmlentities.php
       * SANITIZE: https://www.php.net/manual/en/function.strip-tags.php
       *
       * @param array $data : the data array
       *
       * @return string $data : return the sanitized data
       */
    private function sanitize($data)
    {
        // Page sanitation of data edited by the users
        try {
            foreach ($data as $row) {
                    // $row->data= iconv("UTF-8", "ISO-8859-1", $row->data);
                    // htmlentities($row->title, ENT_QUOTES | ENT_IGNORE, "UTF-8");
                    
                    $row->title = html_entity_decode($row->title);
                    $row->title = strip_tags(htmlentities($row->title));

                    $row->data = html_entity_decode($row->data);
                    $row->data = strip_tags(htmlentities($row->data));
            }
        } catch (\Exception $e) {
            $data = false;
        }

          return $data;
    }
}

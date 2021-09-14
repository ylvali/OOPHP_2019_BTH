<?php
/**
 *  PageView
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


/**
 *  PageView
 *  php version 7
 *  Creates the view in html from PDO obj
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT yso@spektatum.com
 * @link     MIT yso@spektatum.com
 **/

class PageView
{
    /**
     * Page
     *
     * @var object $dbc    The database class
     */


    public $dbC; // The database connection, dbCrud object
    public $filter; // The database connection, dbCrud object

    /**
     * Constructor to initiate
     *
     * @param object $theFilter : the text filter class
     *
     * @return void
     */
    public function __construct(TheTextFilterInterface $theFilter)
    {
        $this->filter = $theFilter;
    }


    /**
     * Display page
     *
     * @param object $pdoRes : the pdo object w blog result
     * @param object $path   : the page path
     *
     * @return string $htmlString
     */
    public function printHTML($pdoRes, $path)
    {
        if (!$pdoRes) {
            return;
        }
        // Sanitize the data
        $pdoRes = $this->sanitize($pdoRes);

        $output = '';
        try {
            foreach ($pdoRes as $entity) {
                $theId = $entity->id;
                $thePath = $entity->path;
                // $slug = $entity->slug;
                $title = $entity->title;
                $data = $entity->data;
                // $type = $entity->type;
                // $published = $entity->published;
                $created = $entity->created;
                // $updated = $entity->updated;
                $deleted = $entity->deleted;
                if ($path != $thePath) {
                    continue;
                }
                $filters = $entity->filter;

                // Create text filter array
                $arrFilters = explode(',', $filters);

                // Filter the data
                $data = $this->filter->parse($data, $arrFilters);

                $output .= "<h1> $title </h1>";
                $output .= "<p> $data </p> <br/>";
                $output .= "<p>| Created: $created |";
                $output .= " Deleted: $deleted |</p>";
                $output .= $this->getActionForm($theId);

                // $output .= "$updated |";
                // $output .= "$deleted |</p>";
            }
        } catch (\Exception $e) {
            return false;
        }
        return $output;
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
                name='pageSection' value='edit'>
                <input type='submit' class='btn1'
                name='pageSection' value='soft_delete'>
                </form>
                ";
        return $form;
    }
}

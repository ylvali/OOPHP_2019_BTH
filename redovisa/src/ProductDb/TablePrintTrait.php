<?php
/**
 *   Table print
 *   php version 7
 *   Project specific table printer
 *
 * @category TablePrint
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Anax\ProductDb;

use Exception;

/**
 *  TablePrintTrait
 *  Prints tables from arrays
 *  Prints buttons
 *
 * @category TablePrint
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
trait TablePrintTrait
{

     /**
      * Creates link for displaying in order
      *
      * @param string $select   : orderBy select variable
      * @param string $settings : the display settings memory
      *
      * @return string $link : link with values
      */
    public function dispInOrder($select, $settings = null)
    {

        if ($settings) {
             $settings = json_encode($settings);
        }

         $link = "<form action='' method='post'>
                  <input type='hidden' name='settings' value=$settings>
                  <input type='hidden' name='orderBy' value=$select>
                  <button type='submit' class='btn1'
                  name='order' value='asc'>&darr;</button>
                  <button type='submit' class='btn1'
                  name='order' value='desc'>&uarr;</button>
                  </form>
                    ";
        return $link;
    }


     /**
      * Create a table from a result array
      *
      * @param array  $resArray : the result in an array
      * @param string $settings : the display settings memory
      *
      * @return string $table : printable table
      */
    public function getStringTable($resArray, $settings = null)
    {

        // Get the special sorting arrows
        $thaId = $this->dispInOrder('id', $settings);
        $thaName = $this->dispInOrder('name', $settings);
        //$thaPic = $this->dispInOrder('pic', $settings);
        $thaYear = $this->dispInOrder('year', $settings);


        // Create a table from the results
        $table = "<table class='tableStyle1'>
                    <tr>
                        <th> <h1> Prints </h1> </th>
                        <th>Id<br/> $thaId </th>
                        <th>Namn<br/>$thaName</th>
                        <th>Year<br/>$thaYear </th>
                        <th><br/></th>
                        <th><br/></th>

                    </tr>";
        foreach ($resArray as $row) {
                $table .= " <tr> ";
                $table .= "<td><img src='{$row->pic}' alt='design'
                           class='itemPic'></td>";
                $table .= "<td>{$row->id}</td>";
                $table .= "<td>{$row->name}</td>";
                $table .= "<td>{$row->year}</td>";

                $btn1 = "<button name='edit' class='btn1' ";
                $btn1 .= "type='submit' value='{$row->id}'>edit</button>";
                $btn2 = "<button name='delete' class='btn1' ";
                $btn2 .= "type='submit' value='{$row->id}'>delete</button>";

                $table .= "<td><form action='' method='post'>$btn1</form></td>";
                $table .= "<td><form action='' method='post'>$btn2</form></td>";
                $table .= "</tr> ";
        }
            $table .= "</table>";

        return $table;
    }

    /**
     * Create a table from a result array without edit option
     *
     * @param array $resArray : array with data to create the table from
     *
     * @return string $table : printable table
     */
    public function getStringTableNoEdit($resArray)
    {
        // var_dump($resArray);
        // Create a table from the results
        $table = "<table class='tableStyle1'>
                   <tr>
                       <th></th>
                       <th>Id</th>
                       <th>Namn</th>
                       <th>Year</th>
                   </tr>";
        foreach ($resArray as $row) {
            $table .= " <tr> ";
            $table .= "<td><img src='{$row->pic}' alt='design'
                       class='itemPic'></td>";
            $table .= "<td>{$row->id}</td>";
            $table .= "<td>{$row->name}</td>";
            $table .= "<td>{$row->year}</td>";
            $table .= "</tr> ";
        }
           $table .= "</table>";

        return $table;
    }


    /**
     * Create and update form from a result array
     *
     * @param array $resArray : result array from PDO
     *
     * @return string $form : printable form
     */
    public function getEditForm($resArray)
    {
        // Create a table from the results
        $form = "<form action='edit' method='post'>";
        foreach ($resArray as $row) {
               $form .= "<label for='id'>ID: {$row->id} </label></br>";
               $form .= "<input type='hidden' name='id'
               value={$row->id}></br>";
               $form .= "<label for='name'>Name: {$row->name} </label></br>";
               $form .= "<input type='name' class='txtField1'
               id='name' name='name'></br>";
               $form .= "<label for='year'>Year: {$row->year} </label></br>";
               $form .= "<input type='text' class='txtField1'
               id='year' name='year'></br>";
               $form .= "<button name='update' class='btn1'
                type='submit' value=''>edit</button>";
        }
           $form .= "</form>";

        return $form;
    }


    /**
     * Create and add form
     *
     * @return string $form : printable form
     */
    public function getAddForm()
    {
        // Create a table from the results
        $form = "<form action='add' method='post'>";
        $form .= "<label for='id'>ID</label></br>";
        $form .= "<input type='text' class='txtField1' id='id'
        name='id' value=''></br>";
        $form .= "<label for='name'>Name</label></br>";
        $form .= "<input type='name' class='txtField1' id='name'
        name='name'></br>";
        $form .= "<label for='year'>Year</label></br>";
        $form .= "<input type='text' class='txtField1' id='year'
         name='year'></br>";
        $form .= "<button name='update' class='btn1' type='submit
        ' value='update'>add</button>";
        $form .= "</form>";

        return $form;
    }


     /**
      * The btn panel
      *
      * @param array $settings : saved display settings
      *
      * @return string printable form
      */
    public function getBtnPanel($settings = null)
    {

        if (!isset($settings)) {
            $settings= array("orderBy" => "id",
            "order" => "desc", "nrItems" => "4");
        }

        $settings = json_encode($settings);

        $thaBtns = "<form action='' class='form1' method='post'>
                  <button name='showAll' class='btn1' type='submit'
                  value='showAll'>All</button>
                  <button name='reset' class='btn1' type='submit'
                  value='reset'>Reset</button>
                  <button name='add' class='btn1' type='submit'
                  value='add'>Add</button>
                  </br> </br>
                  <input name='searchWord' class='txtField1'
                   type='text' value=''/>
                  <button name='search' class='btn1' type='submit'
                  value='search'>Search</button>
                  </form>";

        $thaBtns .= "<form action='' method='post'>
                  <label> Items per page </label>
                  <input type='hidden' name='settings'
                  value=$settings>
                  <button name='nrItems' class='btn1'
                  type='submit' value='2'>| 2 |</button>
                  <button name='nrItems' class='btn1'
                  type='submit' value='4'>| 4 |</button>
                  <button name='nrItems' class='btn1'
                  type='submit' value='6'>| 6 |</button>
                  </form>";

        return $thaBtns;
    }
}

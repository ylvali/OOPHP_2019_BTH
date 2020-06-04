<?php
/*
  Class

*/


/*
*
* Standard class demo : with DockBlock
*
*/

class Person1
{

  /**
  * @var string $name  The name of the person.
  * @var integer $age  The age of the person
  */

    public $name;
    public $age;

  /**
  * @return string with details on person.
  *
  */

    public function details()
    {
        return "My name is {$this->name} and I am {$this->age} years old";
    }
}

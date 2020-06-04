<?php
/*
  Class

*/


/*
*
* Standard class demo : with DockBlock
*
*/

class Person3
{

  /**
  * @var string $name  The name of the person.
  * @var integer $age  The age of the person
  */

    private $name;
    private $age;

  /**
  * @return string with details on person.
  *
  */
    public function details()
    {
        return "My name is {$this->name} and I am {$this->age} years young ";
    }


    /**
    *   Set the age of a person
    *
    *   @return void
    */
    public function setAge(int $age)
    {
        $this->age = $age;
    }


    /**
    *   Get the age of a person
    *
    *   @return void
    */
    public function getAge()
    {
        return $this->age;
    }
}

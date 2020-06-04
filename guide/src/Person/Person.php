<?php
/**
*
* Trying out the namespace
*/

namespace Ylva\Person;

/**
 * Showing off a standard class with methods and properties.
 */
class Person
{
    public $name = "Ylvali";

    public function details()
    {
        return "My name is {$this->name}";
    }
}

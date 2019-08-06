<?php
namespace Ylva\DiceGame;


/*
*  Class : Dice
*
*/


/*
*
* Class for creating the dice
*
*/

class Dice
{
    /**
     *
     * @var int $number   The current number of dice face
     *
     */

    private $number;


    /**
     * Constructor to initiate the object
     * If no number is given, a random one will be set
     *
     * @param int $number The current dice face
     *            None given will generate a random nr
     */
    public function __construct(int $number = Null)
    {
        $this->number = $number;

        if ($number === Null) {
            $this->random();
        }
    }


    /**
     * Randomly set a face nr between 1 - 6.
     *
     * @return void
     */
    public function random()
    {
        $this->number = rand(1, 6);
    }


    /**
     * Get number of the dice.
     *
     * @return int as the nr on the dice
     */
    public function get_dice_nr()
    {
        return $this->number;
    }


    /**
     * Set number of the dice.
     *
     * @return void
     * @throws DiceException when set nr is out of range
     */
    public function set_dice_nr($a_nr)
    {
      $this->number = $a_nr;

      if ($a_nr < 1 || $a_nr > 6) {
          throw new DiceException("Nr between 1 - 6 only");
      }
    }

}

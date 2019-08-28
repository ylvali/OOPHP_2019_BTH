<?php

namespace Anax\DiceGame2;

/*
*  Class : DiceHand
* Implements the interface for the histogram.
* Can display the nr series of dices in a diagram.
*
*/


/*
*
* Class for creating a dice hand and throwing all of the dice
*
*/

class DiceHandHistogram implements HistogramInterface
{

    use HistogramTrait2;

  /**
   *
   * @var int $nrDice        The nr of dice used
   * @var object Player      The player that the hand belongs to
   * @var array $dice        The array of dice
   *
   */

    private $dice = [];
    public $nrDice;
    private $player;


  /**
   *
   * Constructor to initiate the object
   * If no number is given, a random one will be set
   *
   * @param int $numberDice
   * @param object $thePlayer
   *
   */
    public function __construct($numberDice, $thePlayer)
    {
        $this->nrDice = $numberDice;
        $this->player = $thePlayer;

        # Create the dice
        $this->createDice();

        # Create the histogram
        $this->setHistogram();
    }


  /**
   *
   * Create the dice
   *
   */
    public function createDice()
    {
          $nrOfDice = $this->nrDice;

        for ($i=0; $i<$nrOfDice; $i++) {
            $newDice = new Dice();
            array_push($this->dice, $newDice);
        }
    }


  /**
   *
   * Print the dice hand
   *
   * @return array of dice
   *
   */
    public function getDiceHand()
    {
        return $this->dice;
    }


  /**
   *
   * Throw the dice
   *
   * @return void
   *
   */
    public function throwDice()
    {
        $counter = $this->nrDice;
        # $diceArr = $this->dice;

        # Loop through the array of dice & throw each one
        for ($i=0; $i<$counter; $i++) {
            $this->dice[$i]->throwDice();
        }

        # Set new histogram
        $this->setHistogram();
    }


    /**
    *
    * Create a histogram
    *
    * @return void
    *
    */
    public function setHistogram()
    {
        $nrOfDice = $this->nrDice;

        for ($i=0; $i<$nrOfDice; $i++) {
            # Add the new dice to the series in the histogram (in Trait)
            $this->serie[] = $this->dice[$i]->getDiceNr();
        }
    }
}

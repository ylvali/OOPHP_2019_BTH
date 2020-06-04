<?php

namespace Ylva\Dice;

/**
*
* The DiceHand
* Holds 5 dice objects
* Displays their value, their sum and average
*
*/

class DiceHand
{
    private $diceArr = [];
    private $diceNr = []; //Array of the dice nrs


    /**
    *
    * Constructor to create a DiceHand.
    *
    */
    public function __construct()
    {
          // load the dices
        for ($i=0; $i < 5; $i++) {
            $aDice = new Dice();
            array_push($this->diceArr, $aDice);
        }
    }


    /**
    *
    * Makes an array of the dice nrs to present
    * @return string;
    *
    */
    public function theDice()
    {
        $this->diceNr = []; // Empty the array
        $nrDice = count($this->diceArr); // Get nr of dice
        $diceString = ""; // Empty the string

        for ($i=0; $i < $nrDice; $i++) {
            $diceFace = $this->diceArr[$i]->showDice();
            $diceString .= $diceFace . " ";
            array_push($this->diceNr, $diceFace);
        }

        //Loop the dices
        return $diceString;
    }


    /**
    *
    * The sum
    * @return int : Sum of dices
    *
    */
    public function theDiceSum()
    {
        $this->theDice(); // Make sure the array of dice nrs is loaded
        return array_sum($this->diceNr);
    }


    /**
    *
    * The average
    * @return int : Avg of dices
    *
    */
    public function theDiceAvg()
    {
        $sum = $this->theDiceSum(); // Make sure the array of dice nrs is loaded
        $nrDice = count($this->diceNr);

        return $sum/$nrDice;
    }
}

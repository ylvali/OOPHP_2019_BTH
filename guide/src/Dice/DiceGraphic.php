<?php
/*
* Dice graphics
*
*
*/

namespace Ylva\Dice;

/**
 * A graphic dice.
 * Extending the already existing Dice - with graphhics
 */
class DiceGraphic extends Dice
{

  /**
     * Constructor to initiate the dice with six number of sides.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
    * Returns the graphic of a specific nr of dice
    *
    *
    */
    public function graphic()
    {
        //Gets the current nr
        $nrDice = $this->nrOn;

        //Creates a classname
        $className = "dice".$nrDice;

        return $className;
    }
}

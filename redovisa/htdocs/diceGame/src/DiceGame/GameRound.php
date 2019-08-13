<?php
namespace Ylva\DiceGame;

/*
*  Class : GameRound
*
*/


/*
*
* Class for a game round
*
*/

class GameRound
{

    /**
     *
     * @var object Player $thePlayer        The current player
     * @var object DiceHand $theDiceHand    The dice hand
     * @var boolean $won                    If no nr1 in card hand
     * @var int $score                      The calculated score
     * @var int $diceArr                    Array of the dicehand w ints
     * @var boolean $resRegistered          Boolean, is result registered?
     * @var int $theNrOfDice                The nr of dice chosen
     * @var int $roundId                    Id for the round
     *
     */

    public $thePlayer;
    private $theDiceHand;
    private $theNrOfDice;
    private $won = true;
    private $score = 0;
    private $diceArr;
    private $resRegistered = false;
    public $roundId;


    /**
    *
    * Constructor to initiate the object
    * Player as argument, set to play
    * Nr dice is decided and initiates a dicehand obj
    *
    * @param object $aPlayer The player object
    * @param int $nrOfDice   The nr of dice to play
    *
    */
    public function __construct($aPlayer, $nrOfDice)
    {
        $this->theNrOfDice = $nrOfDice;
        $this->thePlayer = $aPlayer;
        $this->theDiceHand = new DiceHand($nrOfDice, $aPlayer);
        $this->roundId = rand(1, 100);

        $this->checkHand();
    }


  /**
   *
   * Checks card hand for nr 1
   *
   * @param object $aPlayer The player object
   * @param int $nrOfDice   The nr of dice to play
   *
   */
    public function checkHand()
    {
        # Get the dice hand in dice objects
        $dHand = $this->theDiceHand;
        $theDiceHandArr = $dHand->getDiceHand();

        # Get the ints from the objects & count the score
        $nrDice = count($theDiceHandArr);
        $intArr = [];
        $totalScore = 0;

        for ($i=0; $i<$nrDice; $i++) {
            $nrDiceInt = $theDiceHandArr[$i]->getDiceNr();
            array_push($intArr, $nrDiceInt);
            $totalScore += $nrDiceInt;
        }

        # Check if there is nr 1
        $oneFound = in_array(1, $intArr);

        # Register result
        $this->registerResults($totalScore, $oneFound, $intArr);
    }


  /**
   *
   * Registers result
   * Possible to register 1 time per play (because of boolean)
   *
   * @param int $theTotal       The total score
   * @param boolean $oneFound   Is nr 1 found?
   *
   */
    public function registerResults($theTotal, $oneFound, $arrDice = null)
    {

        $this->diceArr = $arrDice;

        if ($this->resRegistered === false) {
            if ($oneFound) {
                $this->won = false;
            } else {
                $this->score += $theTotal;
            }

        # Make sure this function can't be run again and duplicate score
            $this->resRegistered = true;
        }
    }


  /**
   *
   * Checks card hand for nr 1
   *
   * @return int $score   Returns the score
   *
   */
    public function getResult()
    {

        return $this->score;
    }


  /**
   *
   * Gets the array of ints from thrown dice
   *
   * @return array $diceRes   Returns the hand of dice
   *
   */
    public function getDiceResult()
    {

        return $this->diceArr;
    }


  /** ***
   *
   * Check if won
   *
   * @return boolean $won  Returns won
   *
   ** ***/
    public function wonRound()
    {

        return $this->won;
    }


    /** ***
     *
     * Play more
     *
     * @return void   Continue playing
     *
     ** ***/
    public function playMore()
    {
          # reset variables
          $this->won = true;
          $this->resRegistered = false;

          $aPlayer = $this->thePlayer;
          $nrOfDice = $this->theNrOfDice;

          # New card hand
          $this->theDiceHand = new DiceHand($nrOfDice, $aPlayer);
          $this->checkHand();
    }
}

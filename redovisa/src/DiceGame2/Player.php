<?php

namespace Anax\DiceGame2;

/*
*  Class : Player
*
*/


/*
*
* Class for creating the players
*
*/

class Player
{
    /**
     *
     * @var string $name      The name of the player
     * @var int $score        The current score of the player
     * @var boolean $human   If it is a person or a computer
     * @var object Player $nextPlayer  The next player in line
     *
     */

    public $name;
    private $score;
    private $human;
    private $nextPlayer;


    /**
     * Constructor to initiate the object
     * Default is that there is no name, it is a computer & no next player
     *
     * @param int $number The current dice face
     *            None given will generate a random nr
     */
    public function __construct($name = null, $human = false, $nextPlayer = null)
    {
        $this->name = $name;
        $this->human = $human;
        $this->nextPlayer = $nextPlayer;
    }


    /**
     * Set the name
     *
     * @return void
     */
    public function setName($theName)
    {
        $this->name = $theName;
    }


    /**
     * Set the name
     *
     * @return string $name   Returns the name
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add to score
     *
     * @return void
     */
    public function addScore($points)
    {
        $this->score += $points;
    }



      /**
       * Get score
       *
       * @return int the score
       */
    public function getScore()
    {
          return $this->score;
    }


    /**
     * Add next player
     *
     * @param Player object
     * @return void
     */
    public function addNextPlayer($aPlayer)
    {
        $this->nextPlayer = $aPlayer;
    }


    /**
     * Get next player
     *
     * @return object the next player
     */
    public function getNextPlayer()
    {
        return $this->nextPlayer;
    }


    /**
     * Set if player is a computer / person
     *
     * @param boolean is player a human? (and not computer)
     * @return void
     */
    public function setIsHuman($isHuman)
    {
        $this->human = $isHuman;
    }


    /**
     * Get if player is a computer / person
     *
     * @return boolean returns if player is a human (False/True)
     */
    public function isHuman()
    {
        return $this->human;
    }
}

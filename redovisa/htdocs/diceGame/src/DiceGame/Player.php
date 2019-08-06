<?php
namespace Ylva\DiceGame;


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
     * @var boolean $person   If it is a person or a computer
     * @var object Player $next_player  The next player in line
     *
     */

      public $name;
      private $score;
      private $person;
      private $next_player;


    /**
     * Constructor to initiate the object
     * Default is that there is no name, it is a computer & no next player
     *
     * @param int $number The current dice face
     *            None given will generate a random nr
     */
    public function __construct($name = Null, $person = False, $next_player = Null )
    {
        $this->name = $name;
        $this->person = $person;
        $this->next_player = $next_player;
    }


    /**
     * Set the name
     *
     * @return void
     */
    public function set_name($the_name)
    {
        $this->name = $the_name;
    }


    /**
     * Add to score
     *
     * @return void
     */
    public function add_score($points)
    {
        $this->score += $points;
    }



      /**
       * Get score
       *
       * @return int the score
       */
      public function get_score()
      {
          return $this->score;
      }


    /**
     * Add next player
     *
     * @return void
     */
    public function add_next_player($a_player)
    {
        $this->next_player = $a_player;
    }


    /**
     * Get next player
     *
     * @return object the next player
     */
    public function get_next_player()
    {
        return $this->next_player;
    }
}

<?php
namespace Ylva\DiceGame;

/*
*  Class : TheGame
*
*/


/*
*
* Class for the Game
*
*/

class TheGame
{

  /**
   *
   * @var int $nrDice               The current number of dice
   * @var array $players            An array with players
   * @var object $firstPlayer       The first player (Player object)
   * @var object $winner            The winning player (Player object)
   * @var object $currentPlayer     The current player (Player object)
   * @var object $currentGameRound  The current game round (Game round object)
   * @var boolean $playAgain         Play the same round again
   *
   */

    private $nrDice;
    private $players;
    private $firstPlayer;
    private $winner;
    private $currentPlayer;
    private $currentGameRound;
    private $playAgain;


  /**
   *
   * Constructor to initiate the object
   *
   *
   * @param int $nrDice     The current nr of dice used
   * @param array $players  An array with players
   *
   */
    public function __construct($nrDice1, $players1)
    {
        $this->nrDice = $nrDice1;
        $this->players = $players1;
        $this->playAgain = false; # default is false

        $this->connectPlayers();
        $this->setFirstPlayer();
    }


  /**
   *
   * Connect the players
   *
   */
    public function connectPlayers()
    {
        $thePlayers = $this->players;
        $nrPlayers = count($thePlayers);

      # Loop through the players so all are connected
        for ($i=0; $i<$nrPlayers; $i++) {
          # If its the end of the list of players, then first player is next
            if ($i == ($nrPlayers - 1)) {
                $thePlayers[$i]->addNextPlayer($thePlayers[0]);
            } else {
                $thePlayers[$i]->addNextPlayer($thePlayers[$i+1]);
            }
        }
    }


  /**
   *
   * Select first player through throwing dice
   * @return void
   *
   */
    public function setFirstPlayer()
    {
        $thePlayers = $this->players;
        $nrPlayers = count($thePlayers);

        # Loop through the players
        # Give each one a dice
        # Save the result in an array

        $theDiceThrown = [];
        for ($i=0; $i<$nrPlayers; $i++) {
            $newDice = new Dice();
            $nrDice = $newDice->getDiceNr();
            array_push($theDiceThrown, $nrDice);
        }

        # The array with thrown dice is parallell to the arr of players
        # Thus the index of the maximum value will also represent
        # the first player

        $maxValue = max($theDiceThrown);
        $maxIndex = array_search($maxValue, $theDiceThrown);
        $firstPlayerObj = $thePlayers[$maxIndex];

        $this->firstPlayer = $firstPlayerObj;
    }


    /**
    *
    * get first player
    * @return Player returns
    *
    */
    public function getFirstPlayer()
    {
        return $this->firstPlayer;
    }


    /**
    *
    * get current player
    * @return Player returns
    *
    */
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }


    /**
    *
    * get the winner
    * @return Player returns
    *
    */
    public function getWinner()
    {
        return $this->winner;
    }


    /**
    *
    * get the players & their scores
    * @return string returns a string of players & scores
    *
    */
    public function getPlayersScore()
    {
        $nrPlayers = count($this->players);
        $res = "";
        $playersArr = $this->players;

        for ($i=0; $i <  $nrPlayers; $i++) {
            $res .= $playersArr[$i]->getName();
            $res .= " ";
            $res .= $playersArr[$i]->getScore();
            $res .= "<br/>";
        }

        return $res;
    }


    /**
    *
    * check the players' score
    * @return boolean
    *
    */

    public function isAWinner()
    {
        $thePlayers = $this->players;
        $nrPlayers = count($thePlayers);
        $hundredPoints = false;

      # Loop through the players and see if any 100p collected
        for ($i=0; $i<$nrPlayers; $i++) {
            $playerScore = $thePlayers[$i]->getScore();
            if ($playerScore >= 100) {
                $hundredPoints = true;
                $this->winner = $thePlayers[$i];
            }
        }

        return $hundredPoints;
    }


    /**
    *
    * Will computer keep playing? Random desicion.
    * @return boolean $keepPlay   True if computer will keep on playing
    *
    */
    public function computerPlay()
    {
        # Random integer between 0 - 1
        $decision = rand(0, 1);
        if ($decision == 0) {
            $playOn = false;
        } else {
            $playOn = true;
        }

        return $playOn;
    }


    /**
    *
    * get the UI buttons
    * @param boolean $isHuman      Set to true if player is a human (not computer)
    * @param boolean $hasWon       Describes if the round was won
    * @param int     $scoreRes     The score to be reported
    * @param array   $diceRes      Array of dice results
    * @return string    $form         Returns the form w result
    *
    */
    public function getUI($isHuman, $hasWon, $scoreRes, $diceRes, $thePlayer)
    {
        $lengthDiceArr = count($diceRes);
        $diceStr = "";
        for ($i=0; $i < $lengthDiceArr; $i++) {
            $diceStr .= strval($diceRes[$i]) . " ";
        }

        $userData = "<h3> Player: ".$thePlayer->getName()." </h3>";
        $userData .= strval($diceStr);


        if ($hasWon) {
            if ($isHuman) {
                $userData .= "<p> You have collected ".$scoreRes."points. <br/>
                              Do you want to keep playing? </p>";
                $userData .= "<button><a href='playAgain.php?play=yes'> Yes </a> </button>";
                $userData .= "<button><a href='playAgain.php?play=no'> No </a> </button>";
            } else if (!$isHuman) {
                # Check if computer will keep on playing
                $playOn = $this->computerPlay();

                if ($playOn) {
                    $userData .= "<p> Collected points this round: </p>";
                    $userData .= "<p> $scoreRes </p>";
                    $userData .= "Computer will keep on playing.";

                    $userData .= "<button><a href='playAgain.php?play=yes'> OK </a> </button>";
                } else {
                    $userData .= "<p> Collected points this round: </p>";
                    $userData .= "<p> $scoreRes </p>";
                    $userData .= "Computer will collect the points now.";

                    $userData .= "<button><a href='playAgain.php?play=no'> OK </a> </button>";
                }
            }
        } else {
            $userData .= "<br/>Sorry, no points. <br/> ";
            $userData .= "<button><a href='nextPlayer.php'> Next player </a> </button>";
        }

        return $userData;
    }


    /**
    *
    * play game
    * @param object $thePlayer The Player (Player obj)
    * @return string $result  Returns result (form/comment)
    *
    */
    public function playGame($thePlayer = null)
    {
        # Check if someone reached the 100 points
        $this->isAWinner();

        # Set current player
        # If one is given as an argument, make it the current one
        # Else, use the current player
        if ($thePlayer) {
            $this->currentPlayer = $thePlayer;
        } else {
            $thePlayer = $this->currentPlayer;
        }

        # Check if there is a winner
        if ($this->winner) {
            # There is a winner
            $theWinner = $this->winner->getName();
            return "There is a winner! <br/>".$theWinner;
        } else {
            # Check if same round should be played
            # Else play a new one
            if ($this->playAgain) {
                $thisRound = $this->currentGameRound;
                $thisRound->playMore();
            } else {
                # Get the nr of dice and start a new round
                $theDice = $this->nrDice;
                $thisRound = new GameRound($thePlayer, $theDice);

                # Save new game round
                $this->currentGameRound = $thisRound;
            }

            # Get the result
            $theScore = $thisRound->getResult();
            $isHuman = $thePlayer->isHuman();
            $hasWon = $thisRound->wonRound();
            $diceRes = $thisRound->getDiceResult();

            $userInterfaceVars = $this->getUI($isHuman, $hasWon, $theScore, $diceRes, $thePlayer);
        }

        # Return the form to the user
        return $userInterfaceVars;
    }


    /**
    *
    * continue playing
    * @return void        sets variable for playing again
    *
    */
    public function setPlayAgain()
    {
        $this->playAgain = true;

        return $this->playAgain;
    }


    /**
    *
    * collect the points from the round
    * @return int      Returns the total score of the player
    *
    */
    public function collectPoints()
    {
        # Get the score from the current game round
        $theScore = $this->currentGameRound->getResult();

        # Set the score to the player
        $this->currentPlayer->addScore($theScore);

        # Return players total score
        return $this->currentPlayer->getScore();
    }

    /**
    *
    * Change to next player
    * @return void
    *
    */
    public function nextPlayer()
    {
        $nextPlayer = $this->currentPlayer->getNextPlayer();
        $this->currentPlayer = $nextPlayer;
        $this->playAgain = false;
    }
}

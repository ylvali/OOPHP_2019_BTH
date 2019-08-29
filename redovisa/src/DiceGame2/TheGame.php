<?php
namespace Anax\DiceGame2;

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
   * @var boolean $playAgain        Play the same round again
   * @var int $nrRounds             The nr of rounds
   * @var int $nrWonRounds        The nr of won rounds
   *
   */

    private $nrDice;
    private $players;
    private $firstPlayer;
    private $winner;
    private $currentPlayer;
    private $currentGameRound;
    private $playAgain;
    private $nrRounds;
    private $nrWonRounds;


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
    * Will computer keep playing?
    * Decision based on probability
    * The computer gets braver and braver.
    *
    * @return boolean $keepPlay   True if computer will keep on playing
    *
    */
    public function computerPlay()
    {
        # Probability of winning : 5/6 = 83.33%

        # If less than 83% of the game rounds have been won,
        # the computer will keep on playing

        # However it will only play again once.

        # This method collects the statistics of how many rounds have been won
        # That value is the base for the decision

        # The computer gets braver, so it will play again at higher %
        # further along the game (after more rounds)


        $gamesWon = $this->getStatisticsInt();
        $playOn = false; # Boolean for flagging if to keep on

        if ($this->playAgain) {
            $playOn = false;
        } else {
            if ($this->nrRounds < 10) {
                if ($gamesWon < 0.83) {
                    $playOn = true;
                }
            } else if ($this->nrRounds < 20) {
                if ($gamesWon < 0.89) {
                    $playOn = true;
                }
            } else {
                if ($gamesWon < 0.95) {
                    $playOn = true;
                }
            }
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
                $userData .= "<button class='gameBtn'><a href='playAgain?play=yes'> Yes </a> </button>";
                $userData .= "<button class='gameBtn'><a href='playAgain?play=no'> No </a> </button>";
            } else if (!$isHuman) {
                # Check if computer will keep on playing
                $playOn = $this->computerPlay();

                if ($playOn) {
                    $userData .= "<p> Collected points this round: </p>";
                    $userData .= "<p> $scoreRes </p>";
                    $userData .= "Computer will keep on playing.";

                    $userData .= "<button class='gameBtn'><a href='playAgain?play=yes'> OK </a> </button>";
                } else {
                    $userData .= "<p> Collected points this round: </p>";
                    $userData .= "<p> $scoreRes </p>";
                    $userData .= "Computer will collect the points now.";

                    $userData .= "<button class='gameBtn'><a href='playAgain?play=no'> OK </a> </button>";
                }
            }
        } else {
            $userData .= "<br/>Sorry, no points. <br/> ";
            $userData .= "<button class='gameBtn'><a href='nextPlayer'> Next player </a> </button>";
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

            # Add round to the statistics
            $this->addRound($hasWon);

            # Get the user interface
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
    * Get the histogram
    * @return string        gets the histogram
    *
    */
    public function getHistogram()
    {
        return $this->currentGameRound->getHistogram();
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


    /**
    *
    * Game statistics
    * Add round
    * Percentage of the nr times that nr 1 has been encountered in the previous rounds
    * @return void
    *
    */
    public function addRound($hasWon = null)
    {
        $this->nrRounds += 1;
        if ($hasWon) {
            $this->nrWonRounds +=1;
        }
    }


    /**
    *
    * Game statistics
    * Check statistics
    * Percentage of nr of wins in the previous rounds
    * @return string
    *
    */
    public function getStatistics()
    {
        $res = $this->nrWonRounds / $this->nrRounds;
        $resPercentage = round((float)$res * 100) . '%';
        $strRes = "<h3> Won rounds: </h3> ".$resPercentage;
        $strRes .= "<h3> Nr of rounds: </h3>".$this->nrRounds;

        return $strRes;
    }


    /**
    *
    * Game statistics
    * Check statistics
    * Percentage of nr of wins in the previous rounds
    * @return int
    *
    */
    public function getStatisticsInt()
    {
        $res = $this->nrWonRounds / $this->nrRounds;

        return $res;
    }
}

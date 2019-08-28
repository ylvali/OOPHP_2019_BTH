<?php

namespace Ylva\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class TheGame
 *
 */
class TheGameObjectTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Check the player connections
     *
     */
    public function testCreateObject()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $res = $player1->getNextPlayer();
        $exp = $player2;
        $this->assertEquals($res, $exp);

        $res2 = $player2->getNextPlayer();
        $exp2 = $player3;
        $this->assertEquals($res2, $exp2);

        $res3 = $player3->getNextPlayer();
        $exp3 = $player1;
        $this->assertEquals($res3, $exp3);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Check that a first player can be added and checked
     * It should be a Player object
     *
     */
    public function testSetFirstPlayer()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $theGame->setFirstPlayer();
        $firstPlayer = $theGame->getFirstPlayer();
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $firstPlayer);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test the function for if there is a winner
     * It should return False before any round is played
     *
     */
    public function testIsAWinner()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $theGame->isAWinner();
        $res = $theGame->getWinner();
        $this->assertNull($res);

        $exp = false;
        $this->assertEquals($res, $exp);

        # Add 100 points
        $player1->addScore(100);
        $res2 = $theGame->isAWinner();

        $exp2 = true;
        $this->assertEquals($res2, $exp2);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test the function for playing a game
     * Test playing with a winner
     * Test playing without an agument for player
     *
     */
    public function testPlayGame()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer();
        #$theGame->playGame($firstPlayer);

        $player1->addScore(100);
        $theGame->isAWinner();
        $theGame->playGame($firstPlayer);

        # Test playing without an argument for player
        # Can only be done once the round has been initiated w a player
        $theGame->playGame();

        # Set play again to enable playing the same round again
        # Can only be done if there is no player w 100 points
        $playerArr2 = [$player2, $player3];
        $theGame2 = new TheGame($nrDice, $playerArr2);
        $firstPlayer = $theGame->getFirstPlayer();
        $theGame2->playGame($firstPlayer);
        $res = $theGame2->setPlayAgain();
        $this->assertTrue($res);
        $theGame2->playGame();
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test the functionality for returning UI data
     *
     */
    public function testGetForm()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $isHuman = true;
        $hasWon = true;
        $theScore = 10;
        $diceRes = [8,2,3,4,5];

        $aForm = $theGame->getUI($isHuman, $hasWon, $theScore, $diceRes, $player1);
        $isString = is_string($aForm);
        $exp = true;
        $this->assertEquals($exp, $isString);

        $isHuman = true;
        $hasWon = false;
        $theScore = 0;
        $diceRes = [1,2,3,4,5];

        $aForm = $theGame->getUI($isHuman, $hasWon, $theScore, $diceRes, $player1);
        $isString = is_string($aForm);
        $exp = true;
        $this->assertEquals($exp, $isString);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test the functionality for returning the current player & score
     *
     */
    public function testGetCurrentPlayerAndScore()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer(); # Get the first player
        $theGame->playGame($firstPlayer); # Start a game

        $currentPlayer = $theGame->getCurrentPlayer();
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $currentPlayer);

        $currentScore = $theGame->getPlayersScore();
        $isString = is_string($currentScore);
        $this->assertTrue($isString);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test the functionality for randomly creating a boolean
     * to decide if computer should keep playing or not
     *
     */
    public function testComputerPlay()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer(); # Get the first player
        $theGame->playGame($firstPlayer); # Start a game

        $keepPlaying = $theGame->computerPlay();
        $isBoolean = is_bool($keepPlaying);
        $this->assertTrue($isBoolean);

        $isH = false; # Is human
        $hWon = true; # Has won
        $scoreRes = 0; # 0 in score
        $dice = [];
        $player = $firstPlayer;

        # Checks that the computer will keep playing based on
        # a decision from the statistics
        $theGame->getUI($isH, $hWon, $scoreRes, $dice, $player);

        # Test that when more rounds are played,
        # the statistics will decide another percentage for continuation
        for ($i=0; $i<25; $i++) {
            $theGame->playGame();
            $keepPlaying = $theGame->computerPlay();
            $isBool = is_bool($keepPlaying);
            $this->assertTrue($isBool);
        }
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test collectPoints
     *
     */
    public function testCollectPoints()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer(); # Get the first player
        $theGame->playGame($firstPlayer); # Start a game

        $playerTotalScore = $theGame->collectPoints();
        $isInt = is_int($playerTotalScore);
        $this->assertTrue($isInt);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test setting the next player
     *
     */
    public function testNextPlayer()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer(); # Get the first player
        $theGame->playGame($firstPlayer); # Start a game
        $theGame->nextPlayer();
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test getting a histogram & statistics report
     *
     */
    public function testHistogramAndStatistics()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $playerArr = [$player1, $player2, $player3];
        $nrDice = 5;

        $theGame = new TheGame($nrDice, $playerArr);
        $this->assertInstanceOf("\Ylva\DiceGame\TheGame", $theGame);

        $firstPlayer = $theGame->getFirstPlayer(); # Get the first player
        $theGame->playGame($firstPlayer); # Start a game

        $histogram = $theGame->getHistogram();
        $isString = is_string($histogram);
        $this->assertTrue($isString);

        $statistics = $theGame->getStatistics();
        $isString = is_string($statistics);
        $this->assertTrue($isString);
    }
}

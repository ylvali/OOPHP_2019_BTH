<?php

namespace Anax\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class GameRound
 *
 */
class GameRoundTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Add a player and check that it is registered
     *
     */
    public function testCreateObject()
    {
        $thePlayer = new Player();
        $nrDice = 5;
        $aGameRound = new GameRound($thePlayer, $nrDice);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound);

        $res = $aGameRound->thePlayer;
        $exp = $thePlayer;
        $this->assertEquals($exp, $res);
    }

    /**
     *
     * Construct object and verify that the object is as expected
     * Make sure that the checkHand functionality can be run twice
     * without doubling the score of the round
     *
     */
    public function testCheckHand()
    {
        $thePlayer2 = new Player();
        $nrDice2 = 5;
        $aGameRound2 = new GameRound($thePlayer2, $nrDice2);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound2);

        $score1 = $aGameRound2->getResult();
        $aGameRound2->checkHand();
        $res = $aGameRound2->getResult();
        $exp = $score1;
        $this->assertEquals($exp, $res);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Check so that the getResult delivers an int
     *
     */
    public function testGetResult()
    {
        $thePlayer3 = new Player();
        $nrDice3 = 5;
        $aGameRound3 = new GameRound($thePlayer3, $nrDice3);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound3);

        $score1 = $aGameRound3->getResult();
        $isInt = is_int($score1);
        $this->assertTrue($isInt);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test to get the round of dice as an array w ints
     *
     */
    public function testGetDiceResult()
    {
        $thePlayer3 = new Player();
        $nrDice3 = 5;
        $aGameRound3 = new GameRound($thePlayer3, $nrDice3);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound3);

        $diceArr = $aGameRound3->getDiceResult();
        $isArr = is_array($diceArr);
        $this->assertTrue($isArr);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Check so that the getResult delivers an int
     *
     */
    public function testRegisterResults()
    {
        $thePlayer4 = new Player();
        $nrDice4 = 5;
        $aGameRound4 = new GameRound($thePlayer4, $nrDice4);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound4);

        $total = 400;
        $oneFound = true;
        $aGameRound4->registerResults($total, $oneFound);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Test that the won param is returned
     *
     */
    public function testRoundWon()
    {
        $thePlayer4 = new Player();
        $nrDice4 = 5;
        $aGameRound4 = new GameRound($thePlayer4, $nrDice4);
        $this->assertInstanceOf("\Anax\DiceGame\GameRound", $aGameRound4);

        $result = $aGameRound4->wonRound();
        $isBoolean = is_bool($result);
        $exp = true;
        $this->assertEquals($exp, $isBoolean);
    }
}

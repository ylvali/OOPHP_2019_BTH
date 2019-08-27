<?php

namespace Ylva\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class DiceHand
 *
 */
class DHHistogramObjectTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Add a properties nr of dice & player
     * Make sure the dice are returned as an array .
     *
     */
    public function testCreateObject()
    {
        $aPlayer = new Player();
        $nrDice = 5;
        $aDiceHand = new DiceHandHistogram($nrDice, $aPlayer);
        $this->assertInstanceOf("\Ylva\DiceGame\DiceHandHistogram", $aDiceHand);

        $diceArr = $aDiceHand->getDiceHand();
        $isArray = is_array($diceArr);
        $exp = true;

        $this->assertEquals($isArray, $exp);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Throw the dice
     * Check that the dice are available in the array
     *
     */
    public function testThrowDice()
    {
        $aPlayer2 = new Player();
        $nrDice2 = 5;
        $aDiceHand2 = new DiceHandHistogram($nrDice2, $aPlayer2);
        $this->assertInstanceOf("\Ylva\DiceGame\DiceHandHistogram", $aDiceHand2);

        $aDiceHand2->throwDice();
        $diceArr2 = $aDiceHand2->getDiceHand();
        $isArray2 = is_array($diceArr2);
        $exp2 = true;

        $this->assertEquals($isArray2, $exp2);
    }
}

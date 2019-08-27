<?php

namespace Ylva\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class Dice
 *
 */
class DiceObjectTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Add a property and make sure that it is correct.
     *
     */
    public function testCreateObject()
    {
        $aDice = new Dice();
        $this->assertInstanceOf("\Ylva\DiceGame\Dice", $aDice);

        $aDice->setDiceNr(3);
        $res = $aDice->getDiceNr();
        $exp = 3;
        $this->assertEquals($exp, $res);
    }


    /**
    *
    * Test throwing the dice
    *
    */
    public function testThrowDice()
    {
        $aDice2 = new Dice();
        $this->assertInstanceOf("\Ylva\DiceGame\Dice", $aDice2);

        $aDice2->throwDice();
        $res = $aDice2->getDiceNr();
        $this->assertLessThan(7, $res);
    }
}

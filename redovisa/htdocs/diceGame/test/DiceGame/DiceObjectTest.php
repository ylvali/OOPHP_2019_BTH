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
        $a_dice = new Dice();
        $this->assertInstanceOf("\Ylva\DiceGame\Dice", $a_dice);

        $a_dice->set_dice_nr(3);
        $res = $a_dice->get_dice_nr();
        $exp = 3;
        $this->assertEquals($exp, $res);
    }
}

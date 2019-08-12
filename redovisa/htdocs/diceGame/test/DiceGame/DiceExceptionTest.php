<?php

namespace Ylva\DiceGame;

use PHPUnit\Framework\TestCase;

/**
*
 * Test cases for class Dice w exception
 *.
 */
class DiceCreateObjectTestException extends TestCase
{

  /**
  *
  * Construct object & test the exception thrown
  *
  */

  // SOLUTION FROM: https://thephp.cc/news/2016/02/questioning-phpunit-best-practices

  /**
     *
     * @expectedException \Ylva\DiceGame\DiceException
     *
     *
     */
    public function testExpectedExceptionIsRaised()
    {
        $aDice = new Dice();
        $this->assertInstanceOf("\Ylva\DiceGame\Dice", $aDice);

        $exc = new DiceException();
        $this->assertInstanceOf("\Ylva\DiceGame\DiceException", $exc);

        $aDice->setDiceNr(200);
    }
}

<?php

namespace Anax\DiceGame2;

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
     * @expectedException \Anax\DiceGame2\DiceException
     *
     *
     */
    public function testExpectedExceptionIsRaised()
    {
        $aDice = new Dice();
        $this->assertInstanceOf("\Anax\DiceGame2\Dice", $aDice);

        $exc = new DiceException();
        $this->assertInstanceOf("\Anax\DiceGame2\DiceException", $exc);

        $aDice->setDiceNr(200);
    }
}

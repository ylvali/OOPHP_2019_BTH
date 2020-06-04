<?php

namespace Ylva\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTestException extends TestCase
{

  /**
  *
  * Construct object & test the exception thrown
  *
  */

  // SOLUTION FROM: https://thephp.cc/news/2016/02/questioning-phpunit-best-practices

  /**
     *
     * @expectedException \Ylva\Guess\GuessException
     *
     */
    public function testExpectedExceptionIsRaised()
    {
        $guess = new Guess(7, 1);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $exc = new GuessException();
        $this->assertInstanceOf("\Ylva\Guess\GuessException", $exc);

        $guess->makeGuess(200);
    }
}

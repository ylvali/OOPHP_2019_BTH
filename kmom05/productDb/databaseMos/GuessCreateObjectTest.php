<?php

namespace Ylva\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }


/**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use both arguments.
     */
    public function testCreateObjectBothArguments()
    {
        $guess = new Guess(42, 7);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 7;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }


    /**
    * Construct object & verify that the object has the expected secret number
    *
    */
    public function testCreateObjectWSecretNr()
    {
        $guess = new Guess(50);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->number();
        $exp = 50;
        $this->assertEquals($exp, $res);
    }


    /**
    *
    * Construct object & verify that random generates different nrs
    *
    */
    public function testCreateObjectRandomNr()
    {
        $guess = new Guess(-1);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $guess->random();
        $res = $guess->number();

        $guess->random();
        $res2 = $guess->number();

        $this->assertNotEquals($res, $res2);
    }


    /**
    *
    * Construct object & verify that correct nr is verified
    *
    */
    public function testCreateObjectTestCorrectNr()
    {
        $guess = new Guess(7);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->makeGuess(7);
        $exp = "correct!!!";
        $this->assertEquals($exp, $res);
    }


    /**
    *
    * Construct object & verify that no guesses left is reported
    *
    */
    public function testCreateObjectOutOfTries()
    {
        $guess = new Guess(7, 1);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $guess->makeGuess(2);
        $res2 = $guess->makeGuess(1);
        $exp = "no guesses left.";
        $this->assertEquals($exp, $res2);
    }


    /**
    *
    * Construct object & verify that out of range is reported
    *
    */
    public function testCreateObjectHigh()
    {
        $guess = new Guess(7, 1);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->makeGuess(8);
        $exp = "to high...";
        $this->assertEquals($exp, $res);
    }


    /**
    *
    * Construct object & verify that out of range is reported
    *
    */
    public function testCreateObjectLow()
    {
        $guess = new Guess(7, 1);
        $this->assertInstanceOf("\Ylva\Guess\Guess", $guess);

        $res = $guess->makeGuess(2);
        $exp = "to low...";
        $this->assertEquals($exp, $res);
    }
}

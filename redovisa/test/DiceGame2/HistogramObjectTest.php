<?php

namespace Anax\DiceGame2;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class Histogram
 *
 */
class HistogramObjectTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Add a properties nr of dice & player
     * Make sure the dice are returned as an array .
     *
     */
    public function testHistogramObject()
    {
        $aHistogram = new Histogram();
        $this->assertInstanceOf("\Anax\DiceGame2\Histogram", $aHistogram);

        # Create an object to inject implementing the interface
        $aPlayer = new Player();
        $nrDice = 10;
        $aDiceHand = new DiceHandHistogram($nrDice, $aPlayer);

        # Inject the histogram with the data from the object
        $aHistogram->injectData($aDiceHand);

        # Get the data
        $arrayData = $aHistogram->getSerie();
        $isArray = is_array($arrayData);
        $exp = true;

        $this->assertEquals($isArray, $exp);

        # Get data as histogram
        $stringData = $aHistogram->getAsText();
        $isString = is_string($stringData);

        $this->assertEquals($isString, $exp);
    }
}

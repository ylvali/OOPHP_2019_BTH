<?php

namespace Anax\DiceGame;

use PHPUnit\Framework\TestCase;

/**
 *
 * Test cases for class Player
 *
 */
class PlayerObjectTest extends TestCase
{
    /**
     *
     * Construct object and verify that the object is as expected
     * Add a property and make sure that it is correct.
     *
     */
    public function testCreateObject()
    {
        $aPlayer = new Player();
        $this->assertInstanceOf("\Anax\DiceGame\Player", $aPlayer);

        $aPlayer->addScore(10);
        $res = $aPlayer->getScore();
        $exp = 10;
        $this->assertEquals($exp, $res);
    }

    /**
     *
     * Construct object and verify that the object is as expected
     * Add a next player and make sure it is correct
     *
     */
    public function testNextPlayer()
    {
        $aPlayer2 = new Player();
        $aPlayer3 = new Player();
        $this->assertInstanceOf("\Anax\DiceGame\Player", $aPlayer2);
        $this->assertInstanceOf("\Anax\DiceGame\Player", $aPlayer3);

        $aPlayer2->addNextPlayer($aPlayer3);
        $res = $aPlayer2->getNextPlayer();
        $exp = $aPlayer3;
        $this->assertEquals($exp, $res);
    }


    /**
     *
     * Construct object and verify that the object is as expected
     * Add a next player and make sure it is correct
     *
     */
    public function testPlayerName()
    {
        $aPlayer4 = new Player();
        $this->assertInstanceOf("\Anax\DiceGame\Player", $aPlayer4);

        $aPlayer4->setName('Player4');
        $res = $aPlayer4->name;
        $exp = 'Player4';
        $this->assertEquals($exp, $res);
    }



    /**
     *
     * Construct object and verify that the object is as expected
     * Test so a player status (human/computer) can be set
     *
     */
    public function testPlayerStatus()
    {
        $aPlayer5 = new Player();
        $this->assertInstanceOf("\Anax\DiceGame\Player", $aPlayer5);

        $aPlayer5->setName('Player5');
        $aPlayer5->setIsHuman(true);
        $res = $aPlayer5->isHuman(); # Is the player human?
        $exp = true;
        $this->assertEquals($exp, $res);
    }
}

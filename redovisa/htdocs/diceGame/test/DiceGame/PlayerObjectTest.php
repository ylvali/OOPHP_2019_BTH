<?php

namespace Ylva\DiceGame;

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
        $a_player = new Player();
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $a_player);

        $a_player->add_score(10);
        $res = $a_player->get_score();
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
        $a_player2 = new Player();
        $a_player3 = new Player();
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $a_player2);
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $a_player3);

        $a_player2->add_next_player($a_player3);
        $res = $a_player2->get_next_player();
        $exp = $a_player3;
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
        $a_player4 = new Player();
        $this->assertInstanceOf("\Ylva\DiceGame\Player", $a_player4);

        $a_player4->set_name('Player4');
        $res = $a_player4->name;
        $exp = 'Player4';
        $this->assertEquals($exp, $res);
    }
}

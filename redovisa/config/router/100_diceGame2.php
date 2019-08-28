<?php
/**
 *
 * Routes to ease development and debugging.
 *
 */

return [
    "routes" => [
        [
            "info" => "Development and debugging information.",
            "mount" => "diceG",
            "handler" => "\Anax\DiceGame2\AppController",
        ],
    ]
];

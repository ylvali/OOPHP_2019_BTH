<?php
namespace Ylva\ProductDb;

/**
 *
 * DbBase is a base for database connection.
 * It is made for inheritance/dependency injection for database connection.
 * It uses a class Database (by Mos) & configuration to use PDO.
 *
 */
class DbBase
{
    /**
     * @var object $database   The database class
     * @var array $conf    Configuration obj
     */
    private $database;
    private $conf;


    /**
     *
     * Constructor to initiate the object
     * with PDO database communication & config.
     * Depends on interfaces.
     *
     * @param object $database
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(interface $db, interface $config)
    {
        $this->conf = $config;
        $this->database = $db;
    }

}

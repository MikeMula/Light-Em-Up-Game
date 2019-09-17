<?php


class AccountValidationControllerTest extends \PHPUnit\Framework\TestCase
{
    private static $site;
    private static $lights;

    public static function setUpBeforeClass() {
        self::$site = new Lights\Site();
        self::$lights = new Lights\Lights(__DIR__ . '/../..');
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    public function test_pdo() {

        $gamesTable = new Lights\GamesTable(self::$site, self::$lights);
        $this->assertInstanceOf('\PDO', $gamesTable->pdo());
    }


    public function test_insertGameDb() {
        $post = [];
        $gamesTable = new Lights\AccountValidationController(self::$site, [], self::$lights);
        $id = $gamesTable->insertGameDb(1, "myfile");
        $this->assertNotEquals(null, $id);

        $ret = $gamesTable->initializeDbGames(2);
        $this->assertNotEquals(null, $ret);


    }

}
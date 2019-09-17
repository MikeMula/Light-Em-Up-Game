<?php


use Lights\GamesTable;

class GamesTableTest extends \PHPUnit\Framework\TestCase
{
    private static $site;
    private static $lights;

    public static function setUpBeforeClass() {
        self::$site = new Lights\Site();
        self::$lights = new Lights\Lights(__DIR__ . '/../..', self::$site);
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
        $gamesTable = new Lights\GamesTable(self::$site, self::$lights);
        $id = $gamesTable->insertGameDb(1, "myfile");
        $this->assertNotEquals(null, $id);



        $ret = $gamesTable->initializeDbGames(2);
        $this->assertNotEquals(null, $ret);


    }

    public function test_update() {
        $cells = new Lights\Cells(self::$site);
        $cells->updateCell(87, 1, 1, 100);
        $cells->updateCell(87, 2, 6, 500);

    }





//
//    protected function setUp() {
//        $users = new Felis\Users(self::$site);
//        $tableName = $users->getTableName();
//
//        $sql = <<<SQL
//delete from $tableName;
//insert into $tableName(id, email, name, phone, address,
//                      notes, password, joined, role, salt)
//values (7, "dudess@dude.com", "Dudess, The", "111-222-3333",
//        "Dudess Address", "Dudess Notes",
//        "49506d29656ad62805497b221a6bedacc304ad6496997f17fb39431dd462cf48",
//        "2015-01-22 23:50:26", "S", "Nohp6^v\$m(`qm#\$o"),
//        (8, "cbowen@cse.msu.edu", "Owen, Charles", "999-999-9999",
//        "Owen Address", "Owen Notes",
//        "14831e3f21b423a557a0aa99a391a57a2400ef0fdade328890c9048ad3a8ab6a",
//        "2015-01-01 23:50:26", "A", "aeLWK6k`jzPpgZMi"),
//        (9, "bart@bartman.com", "Simpson, Bart", "999-999-9999", "", "",
//        "a747a49bf74523c1760f649707bf3d2b4a858f088520fd98b35def1e6929ca26",
//        "2015-02-01 01:50:26", "C", "7xNhdV-8P#\$p)1c9"),
//        (10, "marge@bartman.com", "Simpson, Marge", "", "", "",
//        "edfc83ceca3a49aef204cee0e51eeb1728f728c56b2ea9037017230cc39ae938",
//        "2015-02-01 01:50:26", "C", '!yhLrEo3d8vD_LNV')
//SQL;
//
//        self::$site->pdo()->query($sql);
//    }

}
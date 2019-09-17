<?php


namespace Lights;


class GamesTable extends Table
{

    private $lights;

    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site, Lights $lights) {
        $this->lights = $lights;
        parent::__construct($site, "game");
    }


    /**
     * Insert game into Game Table in the db
     * @param $userid
     * @param $filename
     * @return |null
     */
    public function insertGameDb($userid, $filename) {
        $sql = <<<SQL
INSERT INTO $this->tableName(userid, filename)
VALUES(?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute([$userid, $filename]) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }


    /**
     * @param $userid
     */
    public function initializeDbGames($userid) {

        $cells = new Cells($this->site); //cells for the game

        //Clear all games and load initial states in DB
        $games = $this->lights->getGames()->getGames();

        foreach($games as $game) {

            //clear grid
            $game->clear();
            $filename = $game->getFile();

            //insert game into DB Game Table
            $gameid = $this->insertGameDb($userid, $filename); //returns id of inserted games

            //get game grid
            $grid = $game->getGrid();

            //insert every cell for this game into DB Cell Table
            if($gameid !== null) { //make sure there was an id returned by insertGame

                for($r = 1; $r<=$game->getHeight();  $r++) {

                    for($c=1; $c<=$game->getWidth();  $c++) {
                       $value = $grid[$r][$c];
                       $cells->insert($gameid, $r, $c, $value); //insert cell into the cells table for this game
                    }
                }


            }

            //at this point games in DB match games in memory (both in initial states)

        }

        return "was in initialize DB and reached this far";
    }


    /**
     * Get all games in Db for this user
     * @param $userid
     * @return |null
     */
    public function getDbGames($userid) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE userid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    /**
     * Get game with given filename for this userid
     * @param $filename
     * @param $userid
     * @return |null
     */
    public function getDbGame($filename, $userid) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE userid=? AND filename=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $filename));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);

    }


    /**
     * Get game row with this id
     * @param $id
     * @return |null
     */
    public function getGameById($id) {

        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);



    }

    /**
     * Clear Game Table with given id
     * @param $id
     *
     */
    public function clearDbGame($id) {
        $file = $this->getGameById($id)['filename'];
        $game = $this->lights->getGames()->getGame($file);
        $cells = new Cells($this->site); //cells for the game

        //clear the game in memory
        $game->clear();


        //get game grid
        $grid = $game->getGrid();

        //insert every cell for this game into DB Cell Table
        for($r = 1; $r<=$game->getHeight();  $r++) {

            for($c=1; $c<=$game->getWidth();  $c++) {
                $value = $grid[$r][$c];
                $cells->updateCell($id, $r, $c, $value); //insert cell into the cells table for this game
            }
        }
    }



}
<?php


namespace Lights;


/**
 * Manage the cells table in our system
 * Class Cells
 * @package Lights
 */

class Cells extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "cell");
    }

    /**
     * Insert a cell into the cells table
     * @param $gameid
     * @param $row
     * @param $col
     * @param $value
     * @return |null
     */
    public function insert($gameid, $row, $col, $value) {
        $sql = <<<SQL
INSERT INTO $this->tableName(gameid, row, col, val)
VALUES(?, ?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute([$gameid, $row, $col, $value]) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();

    }

    /**
     * Get the cells with this game id
     * @param $gameid
     * @return array of Cell objects
     */
    public function getCells($gameid) {

        $sql =<<<SQL
SELECT *    
FROM $this->tableName 
WHERE gameid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$gameid]);

        $cells = [];

        foreach($statement as $row) {
            $cells[] = new Cell($row);
        }

        return $cells;

    }


    /**
     * Update cell for game with this gameid
     * @param $gameid
     * @param $row
     * @param $col
     * @param $val
     * @return bool
     */
    public function updateCell($gameid, $row, $col, $val) {

        $sql =<<<SQL
UPDATE $this->tableName
SET val=?
WHERE gameid=? AND row=? AND col=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($val, $gameid, $row, $col));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        if($statement->rowCount() === 0) {
            //user does not exist
            return false;
        }
        return true; //update successful

    }


}
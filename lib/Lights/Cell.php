<?php


namespace Lights;


class Cell
{
    private $gameid; //the game this cell is in
    //row and column of this cell
    private $row;
    private $col;
    private $value; //the value in the cell

    /**
     * Cell constructor.
     * @param $row
     */
    public function __construct($row)
    {
        $this->gameid = $row['gameid'];
        $this->row = $row['row'];
        $this->col = $row['col'];
        $this->value = $row['val'];

    }

    /**
     * Set the value of a cell with given position
     * @param $row
     * @param $col
     * @param $values
     */
    public function setCell($row, $col, $value) {
        $this->row = $row;
        $this->col = $col;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getGameid()
    {
        return $this->gameid;
    }

    /**
     * @param mixed $gameid
     */
    public function setGameid($gameid)
    {
        $this->gameid = $gameid;
    }

    /**
     * @return mixed
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param mixed $row
     */
    public function setRow($row)
    {
        $this->row = $row;
    }

    /**
     * @return mixed
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * @param mixed $col
     */
    public function setCol($col)
    {
        $this->col = $col;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}
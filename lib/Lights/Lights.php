<?php
/**
 * @file
 * This is the main system class for the Lights game.
 * It is what is stored in the session.
 */

namespace Lights;

/**
 * This is the main system class for the Lights game.
 * It is what is stored in the session.
 */
class Lights {
    /**
     * Lights constructor.
     * @param string $dir Root directory for the site.
     */
    public function __construct($dir, Site $site) {

        $this->games = new Games($this, $dir);
        $this->site = $site;
        $this->dir = $dir;
    }

    /**
     * Get the games object
     * @return Games object
     */
    public function getGames() {
        return $this->games;
    }

    /**
     * Set a message that appears on a page.
     *
     * This is used for error messages.
     * @param $message Message string to set
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return Get any current message
     */
    public function getMessage() {
        return $this->message;
    }


    /**
     * Set the player's name
     * @param $player Player name
     */
    public function setPlayer($player) {
        $this->player = $player;
    }

    /**
     * @return string Player name
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * Set the current game based on a filename
     * @param string $file File name for the game to set
     * @return true if successful
     */
    public function setGameByFile($file) {
        $this->game = $this->games->getGame($file);
        return $this->game !== null;
    }


    /**
     * Set the current game based on table in the database
     * @param $file string file name for the game
     * @param $userid userid to whom this game belongs
     *  @return true if successful
     */
    public function setGameByDb($file) {
        $this->games = new Games($this, $this->dir); //Games constructor should detect a user is logged in and load games from db
        $this->game = $this->games->getGame($file);
        return $this->game !== null;
    }


    /**
     * Clear pointer for current game. No game will be active.
     */
    public function clearGame() {
        $this->game = null;
    }

    /**
     * Get the currently active game
     * @return Game object
     */
    public function getGame() {
        return $this->game;
    }

    /**
     * If the Show Lighted option selected?
     * @return bool True if so
     */
    public function isShowLighted()
    {
        return $this->showLighted;
    }

    /**
     * @param bool $showLighted
     */
    public function setShowLighted($showLighted)
    {
        $this->showLighted = $showLighted;
    }

    /**
     * @return bool
     */
    public function isShowCompleted()
    {
        return $this->showCompleted;
    }

    /**
     * @param bool $showCompleted
     */
    public function setShowCompleted($showCompleted)
    {
        $this->showCompleted = $showCompleted;
    }

    /**
     * Check if a user is logged in
     * @return bool
     */
    public function isLoggedIn() {
        return $this->userid !== null;
    }

    /**
     * Set the id of a logged in user
     * @param $id
     */
    public function setUserId($id) {
        echo "hahahaha";
        $this->userid = $id;
    }

    /**
     * get user id of a logged in user
     * @return null
     */
    public function getUserId() {
        return $this->userid;
    }

    /**
     * @return Site|null
     */
    public function getSite()
    {
        return $this->site;
    }





    private $games;
    private $game = null;       // The current game
    private $message = null;	// Any error message for the pages?
    private $player = "";		// Player name
    private $userid = null;     //internal ID for user if logged in
    private $site = null;       //site object
    private $dir = "";

    private $showLighted = false;
    private $showCompleted = false;
}
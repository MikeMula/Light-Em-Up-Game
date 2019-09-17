<?php
/**
 * The collection of available games.
 */

namespace Lights;

/**
 * The collection of available games.
 */
class Games
{
    /**
     * Games constructor.
     * @param string $dir Root directory for the site.
     */
    public function __construct(Lights $lights, $dir)
    {
        $this->lights = $lights;

        //if a user is logged in, load the games from the database; otherwise, load games from memory
        if($lights->isLoggedIn()) {
            $this->loadDbGames($dir);
        }
        else {
            $this->load($dir);
        }

    }

    /**
     * Load the games from disk.
     * @param string $dir Root directory for the site.
     */
    private function load($dir)
    {
        $this->games = [];

        $files = scandir($dir . '/games');
        foreach ($files as $file) {
            $len = strlen($file);
            if (substr($file, $len - 5) === '.json') {
                // We have found a file!
                $this->games[$file] = new Game($this->lights, $dir . '/games/', $file);
            }
        }
    }

    /**
     * Load games from database for userid
     * @param $userid
     */
    public function loadDbGames($dir)
    {
        $this->games = [];

        $files = scandir($dir . '/games');
        foreach ($files as $file) {
            $len = strlen($file);
            if (substr($file, $len - 5) === '.json') {
                // We have found a file!
                $game = new Game($this->lights, $dir . '/games/', $file);
                $game->loadGameFromDb($file); //load the game for this file name from the data in the db
                $this->games[$file] = $game;
            }
        }


    }


    /**
     * Get available games.
     * @return array of Game objects
     */
    public function getGames()
    {
        return array_values($this->games);
    }

    /**
     * Get a game by the filename
     * @param string $file
     * @return Game object or null
     */
    public function getGame($file)
    {
        if (isset($this->games[$file])) {
            return $this->games[$file];
        }

        return null;
    }


    private $lights;
    private $games = [];

}


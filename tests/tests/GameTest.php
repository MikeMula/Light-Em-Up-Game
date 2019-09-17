<?php

use Lights\Game;

/** @file
 * Unit tests for the class Game
 * @cond 
 */
class GameTest extends \PHPUnit\Framework\TestCase
{
	public function test_loaded() {
        $lights = new \Lights\Lights(__DIR__ . '/../..');
        $this->assertTrue($lights->setGameByFile('5x5easy-1.json'));

        $game = $lights->getGame();

        $this->assertEquals(5, $game->getRows());
        $this->assertEquals(5, $game->getCols());
        $this->assertEquals('5x5 Easy', $game->getTitle());
        $grid = $game->getGrid();
        $solution = $game->getSolution();

        // Test the walls:
        // {"row": 1, "col": 5, "value": 0},
        // {"row": 2, "col": 1, "value": null},
        // {"row": 2, "col": 3, "value": 1},
        // {"row": 3, "col": 1, "value": 2},
        // {"row": 5, "col": 4, "value": null}

        $this->assertEquals(0, $grid[1][5]);
        $this->assertEquals(Game::WALL, $grid[2][1]);
        $this->assertEquals(1, $grid[2][3]);
        $this->assertEquals(2, $grid[3][1]);
        $this->assertEquals(Game::WALL, $grid[5][4]);

        // Test the lights:
        // {"row": 1, "col": 1},
        // {"row": 2, "col": 4},
        // {"row": 3, "col": 2},
        // {"row": 4, "col": 1},
        // {"row": 5, "col": 3},
        // {"row": 5, "col": 5}
        $this->assertEquals(Game::LIGHT, $solution[1][1]);
        $this->assertEquals(Game::LIGHT, $solution[2][4]);
        $this->assertEquals(Game::LIGHT, $solution[3][2]);
        $this->assertEquals(Game::LIGHT, $solution[4][1]);
        $this->assertEquals(Game::LIGHT, $solution[5][3]);
        $this->assertEquals(Game::LIGHT, $solution[5][5]);
	}
}

/// @endcond

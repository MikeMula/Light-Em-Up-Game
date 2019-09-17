<?php

/** @file
 * Unit tests for the class Game
 * @cond 
 */
class LightsTest extends \PHPUnit\Framework\TestCase
{
	public function test_set() {
		$lights = new \Lights\Lights(__DIR__ . '/../..');

        $this->assertNull($lights->getMessage());
        $lights->setMessage('test message');
        $this->assertEquals('test message', $lights->getMessage());
	}
}

/// @endcond

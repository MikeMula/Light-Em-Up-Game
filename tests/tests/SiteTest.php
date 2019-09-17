<?php


class SiteTest extends \PHPUnit\Framework\TestCase
{

    public function test_getEmail() {
        $site = new Lights\Site();
        $site->setEmail("mikemula97@gmail.com");
        $this->assertEquals("mikemula97@gmail.com", $site->getEmail());
    }

    public function test_setEmail() {
        $site = new Lights\Site();
        $site->setEmail("mikemula9777@gmail.com");
        $this->assertEquals("mikemula9777@gmail.com", $site->getEmail());
    }

    public function test_setRoot() {
        $site = new Lights\Site();
        $site->setRoot("index.php");
        $this->assertEquals("index.php", $site->getRoot());
    }

    public function test_getRoot() {
        $site = new Lights\Site();
        $site->setRoot("game.php");
        $this->assertEquals("game.php", $site->getRoot());
    }

    public function test_getTablePrefix() {
        $site = new Lights\Site();
        $site->dbConfigure("DemoDB", "kamwanam@msu.edu", "1234abcd", "Sir.");
        $this->assertEquals("Sir.", $site->getTablePrefix());

    }

    public function test_localize() {
        $site = new Lights\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize($site);
        }
        $this->assertEquals('testp2_', $site->getTablePrefix());
    }
}
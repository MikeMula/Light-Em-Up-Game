<?php
require_once "../lib/game.inc.php";
$controller = new \Lights\GameController($lights, $_POST);
//echo $controller->showRedirect();
header("location: " . $controller->getRedirect());
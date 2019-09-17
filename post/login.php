<?php


require '../lib/game.inc.php';

$controller = new Lights\LoginController($site, $_POST, $lights);
header("location: " . $controller->getRedirect());
//print_r($_POST);
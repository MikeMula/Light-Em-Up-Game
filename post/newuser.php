<?php
require '../lib/game.inc.php';

$controller = new Lights\NewUserController($site, $_POST);
header("location: " . $controller->getRedirect());

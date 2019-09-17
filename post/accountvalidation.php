<?php
require '../lib/game.inc.php';

$controller = new Lights\AccountValidationController($site, $_POST, $lights);
header("location: " . $controller->getRedirect());
//print_r($_POST);


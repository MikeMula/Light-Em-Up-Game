<?php

require '../lib/game.inc.php';
unset($_SESSION['lights']); //unset user from session to log out
header("location: ".$site->getRoot());

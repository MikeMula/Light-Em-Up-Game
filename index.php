<?php
require_once "lib/game.inc.php";
//$_SESSION[LIGHTS_SESSION] = new Lights\Lights(__DIR__);
//$lights = $_SESSION[LIGHTS_SESSION];
$view = new Lights\IndexView($lights, $_SESSION, $_POST);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Light Em Up!</title>
	<link href="game.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php echo $view->present(); ?>
</body>
</html>

<!---->
                <!--CHECK THIS OUT-->

<!--Next to instructions should have buttons New Account, Login, and -->
<!--replaces with logout when logged in. Note that if the user is -->
<!--logged in, they should not be able to change the name (make the input box unchangable)-->

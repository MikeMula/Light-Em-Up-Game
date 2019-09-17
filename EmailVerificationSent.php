<?php
require_once "lib/game.inc.php";
//$_SESSION[LIGHTS_SESSION] = new Lights\Lights(__DIR__);
//$lights = $_SESSION[LIGHTS_SESSION];
$view = new Lights\EmailVerificationSentView($lights);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Light Em Up! Verification Email Sent</title>
    <link href="game.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="game.js"></script>
</head>

<body>
<?php echo $view->present(); ?>
</body>
</html>

<?php


namespace Lights;


class LoginView extends View
{
    private $error = null; //any error on the page

    /**
     * NewUserView constructor.
     * @param Lights $lights
     */
    public function __construct(Lights $lights, array $session, array $get) {
        parent::__construct($lights);

        if(isset($get['e'])) {
            $this->setError("Invalid login credentials!");
        }

    }

    /**
     * Present the page header
     * @return string HTML
     */
    public function present_header() {
        $html = parent::present_header();

        $html .= <<<HTML
<h1 class="center">Login</h1>
</header>
HTML;

        return $html;
    }


    /**
     * Present the page body
     * @return string HTML
     */
    public function present_body()
    {

        $html = <<<HTML
<div class="body">
<form class="newgame" method="post" action="post/login.php">
	<div class="controls">
	<p class="name"><label for="email">Email </label><br><input type="email" id="email" name="email" placeholder="Email"></p>
	<p class="name"><label for="email">Password </label><br><input type="password" id="password" name="password" placeholder="password"></p>
	<p><button>Login</button></p>
    <p><button id="cancel">Cancel</button></p>
	</div>
HTML;

        if ($this->getError() !== null) { //display error if any occurs
            $message = $this->getError();
            $html .= "<p class=\"msg\">$message</p>";
        }

        $html .= <<<HTML
</form>
</div>
HTML;
        return $html;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

}
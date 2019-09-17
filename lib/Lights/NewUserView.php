<?php


namespace Lights;


class NewUserView extends View
{


    const EMAIL_EXISTS = -200;
    private $error = null;   //any error on the page
    private $site;

    /**
     * NewUserView constructor.
     * @param Site $site
     * @param array $get
     */
    public function __construct(Site $site, array $get) {
        $this->site = $site;

        //Errors  //CHECK THIS LOGIC
        if (isset($get['e'])) {
            if ($get['e'] == self::EMAIL_EXISTS) {
                $this->setError("Email already exists!");
            }

        }

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

    /**
     * Present the page header
     * @return string HTML
     */
    public function present_header() {
        $html = parent::present_header();

        $html .= <<<HTML
<h1 class="center">Sign Up</h1>
</header>
HTML;

        return $html;
    }


    /**
     * Present the page body
     * @return string HTML
     */
    public function present_body() {

        $html = <<<HTML
<div class="body">

<form class="newgame" method="post" action="post/newuser.php">
    <p>If you create an account on Light Em Up!, you can save and load games as you play.</p>
	<div class="controls">
	<p class="name"><label for="name">Name </label><br><input type="text" id="name" name="name" ></p>
	<p class="name"><label for="email">Email </label><br><input type="email" id="email" name="email" ></p>
	<p><button id="create" name="create">Create Account</button></p>
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

}
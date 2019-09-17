<?php


namespace Lights;


class AccountValidationView extends View
{

    private $site;
    private $error = null;
    private $validator; //passed to controller via hidden field

    const EMAIL_DOES_NOT_MATCH_VALIDATOR = -12;
    const PASSWORDS_NOT_MATCH = -13;
    const PASSWORD_TOO_SHORT = -14;
    const INVALID_VALIDATOR = -10;


    /**
     * Constructor
     * Sets the page title and any other settings.
     * @param Site $site The Site object
     */
    public function __construct(Site $site, array $get)
    {
        $this->site = $site;
        $this->setRedirect("index.php");

        if(isset($get['v'])) { $this->validator = strip_tags($get['v']); }


        //Errors  //CHECK THIS LOGIC
        if (isset($get['e'])) {
            if ($get['e'] == self::EMAIL_DOES_NOT_MATCH_VALIDATOR) {
                $this->setError("Email address does not match validator");
            } else if ($get['e'] == self::PASSWORDS_NOT_MATCH) {
                $this->setError("Passwords did not match");
            } else if ($get['e'] == self::PASSWORD_TOO_SHORT) {
                $this->setError("Password too short");
            } else if ($get['e'] == self::INVALID_VALIDATOR) {
                $this->setError("Invalid or expired validator");
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
    } //any error on the page


    /**
     * Present the page body
     * @return string HTML
     */
    public function present_body()
    {

        $html = <<<HTML
<div class="body">

<form class="newgame" method="post" action="post/accountvalidation.php">
	<div class="controls">
	<p class="name"><label for="email">Email </label><br><input type="email" id="email" name="email" placeholder="Email"></p>
	<p class="name"><label for="email">Password: </label><br><input type="password" id="password1" name="password1" placeholder="password"></p>
	<p class="name"><label for="password2">Password(again): </label><br><input type="password" id="password2" name="password2" placeholder="password"></p>
	<p><button id="create">Create Account</button></p>
    <p><button id="cancel">Cancel</button></p>
    <input type="hidden" name="validator" value="$this->validator">
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
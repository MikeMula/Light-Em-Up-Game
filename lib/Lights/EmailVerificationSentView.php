<?php


namespace Lights;


class EmailVerificationSentView extends View
{

    /**
     * NewUserView constructor.
     * @param Lights $lights
     */
    public function __construct(Lights $lights) {
        parent::__construct($lights);

    }

    /**
     * Present the page header
     * @return string HTML
     */
    public function present_header() {
        $html = parent::present_header();

        $html .= <<<HTML
<h1 class="center">Verification email sent.</h1>
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

<form class="newgame" method="post" action="">
    <p class="message">An email message has been sent to your address. When it arrives, 
       select the validate link in the email to validate your account
    </p>
	<div class="controls">
    <p><button id="cancel">Home</button></p>
	</div>
</form>
</div>
HTML;

        return $html;
    }

}
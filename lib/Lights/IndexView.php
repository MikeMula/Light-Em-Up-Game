<?php
/**
 * View class for the Index (main) page
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * View class for the Index (main) page
 */
class IndexView extends View {

    private  $post;

	public function __construct(Lights $lights, array $session, array &$post) {
		parent::__construct($lights);
		$this->post = $post;

		$lights->clearGame();

		//if($lights->isLoggedIn()) { $this->isLoggedIn = true; $this->user = $session['user']; }
	}

	/**
	 * Present the page header
	 * @return string HTML
	 */
	public function present_header() {
		$html = parent::present_header();

		//LINKS REPLACED WITH LOGOUT IF USER IS LOGGED IN
        if($this->lights->isLoggedIn()) {
            $html .= <<<HTML
<nav><p><a href="post/logout.php">LOGOUT</a>&nbsp<a href="instructions.php">INSTRUCTIONS</a></p></nav>
<h1 class="center">Welcome to Mike Kamwana's Light Em Up!</h1>
</header>
HTML;
        }

        else {
            $html .= <<<HTML
<nav><p><a href="newuser.php">NEW USER</a>&nbsp;<a href="login.php">LOGIN</a>&nbsp<a href="instructions.php">INSTRUCTIONS</a></p></nav>
<h1 class="center">Welcome to Mike Kamwana's Light Em Up!</h1>
</header>
HTML;
        }

		return $html;
	}

	/**
	 * Present the page body
	 * @return string HTML
	 */
	public function present_body() {
	    $lights = $this->getLights();
	    $games = $lights->getGames()->getGames();

		$html = <<<HTML
<div class="body">
<form class="newgame" method="post" action="post/index-post.php">
	<div class="controls">
HTML;
		if($this->lights->isLoggedIn()) {
            $name = $lights->getPlayer();
            $html .= <<<HTML
	<p class="name"><label for="name">Name </label><br><input type="text" id="name" name="name" value="$name" disabled></p>
	<p class="name"><label for="name">Name </label><br><input type="hidden" id="name" name="name" value="$name"></p>
	<p><select name="game">
HTML;

        }

		else {
            $name = $lights->getPlayer();
            $html .= <<<HTML
	<p class="name"><label for="name">Name </label><br><input type="text" id="name" name="name" value="$name"></p>
	<p><select name="game">
HTML;

        }

		foreach($games as $game) {
			$title = $game->getTitle();
			$file = $game->getFile();
			$html .= "<option value=\"$file\">$title</option>";
		}

		$html .= <<<HTML
		</select></p>
	<p><button>Start or Continue Game</button></p>
HTML;
		if($lights->getMessage() !== null) {
			$html .= '<p class="message">' . $lights->getMessage() . '</p>';
		}

		$html .= <<<HTML
	</div>
</form>
</div>
HTML;

		return $html;
	}
}
<?php


namespace Lights;


class LoginController extends Controller
{
    private $redirect; // Page we will redirect the user to.


    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $post $_POST
     * @param Lights $lights object
     */
    public function __construct(Site $site, array $post, Lights $lights) {
        parent::__construct($lights);

        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);

        $root = $site->getRoot();
        if($user === null) {
            // Login failed
            $this->redirect = "$root/login.php?e";

        } else {

                $lights->setUserId($user->getId()); //set user id for logged in user
                $lights->setPlayer($user->getName()); //set name of logged in player
                $this->redirect = "$root/index.php";
        }


    }


    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

}
<?php


namespace Lights;


class NewUserController
{
    private $redirect; // Page we will redirect the user to.
    const EMAIL_EXISTS = -200;

    /**
     * NewUserController constructor.
     * @param Site $site
     * @param array $post
     */
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/EmailVerificationSent.php";

        if(isset($post["create"])) {
            $users = new Users($site);
            $name = strip_tags($post["name"]);
            $email = strip_tags($post["email"]);
            $mailer = new Email();
            $ret = $users->sendVerification($name, $email, $mailer);

            if($ret !== null) {
                $this->redirect = "$root/newuser.php?e=".self::EMAIL_EXISTS;
            }


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
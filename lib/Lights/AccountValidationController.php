<?php


namespace Lights;


class AccountValidationController
{
    private $redirect; // Page we will redirect the user to.

    const EMAIL_DOES_NOT_MATCH_VALIDATOR = -12;
    const PASSWORDS_NOT_MATCH = -13;
    const PASSWORD_TOO_SHORT = -14;
    const INVALID_VALIDATOR = -10;

    /**
     * NewUserController constructor.
     * @param Site $site
     * @param array $post
     * @param Lights object
     */
    public function __construct(Site $site, array $post, Lights $lights)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/index.php";


        $users = new Users($site);
        $validators = new Validators($site);

        $validator = strip_tags($post['validator']);
        $email = strip_tags($post["email"]);
        $password = strip_tags($post['password1']);


        //
        // 1. Ensure the validator is correct! Use it to get the user email associated with validator.
        //
        $name = $validators->get($email)['name']; //get name associated with this validator
        $correctValidator = $validators->get($email)['validator']; //validator in db
        $validatorSalt = $validators->get($email)['salt']; //validator salt in db

        if($name === null) {
            // Email entered is invalid, not for this validator
            $this->redirect = "$root/accountvalidation.php?v=$validator&e=".self::EMAIL_DOES_NOT_MATCH_VALIDATOR;
            return;
        }

        // Ensure validator is valid
        if($correctValidator !== hash("sha256", $validator . $validatorSalt)) {
            //validator invalid
            $this->redirect = "$root/accountvalidation.php?v=$validator&e=".self::INVALID_VALIDATOR;
            return;
        }

        //
        // 2. Ensure the passwords match each other
        //
        $password1 = trim(strip_tags($post['password1']));
        $password2 = trim(strip_tags($post['password2']));
        if($password1 !== $password2) {
            // Passwords do not match
            $this->redirect = "$root/accountvalidation.php?v=$validator&e=".self::PASSWORDS_NOT_MATCH;
            return;
        }

        if(strlen($password1) < 8) {
            // Password too short
            $this->redirect = "$root/accountvalidation.php?v=$validator&e=".self::PASSWORD_TOO_SHORT;
            return;
        }

        // 3. Add user to database
        //
        $userid = $users->add($email, $name, $password, $validator); //returns id for added user
        echo "I just added a user with ID: ";
        echo $userid;


        // 4. initialize db game tables for this account
        //s
        $gamesTable = new GamesTable($site, $lights);
        $gamesTable->initializeDbGames($userid);

        //
        // 5. Destroy the validator record so it can't be used again!
        //

        $validators->remove($email);

        //redirect to home if create is clicked with valid inputs
        if(isset($post['create'])) {

            $this->redirect = "$root/";
            return;
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
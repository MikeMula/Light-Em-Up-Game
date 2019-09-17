<?php
namespace Lights;

class EmailMock extends Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}

/**
 * Manage users in our system.
 */
class Users extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }


    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @return User object if successful, null otherwise.
     */
    public function login($email, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute([$email]);
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @return User object if successful, null otherwise.
     */
    public function get($id) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }
        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user) {
        $sql =<<<SQL
UPDATE $this->tableName
SET email=?, name=?
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($user->getEmail(), $user->getName(), $user->getId()));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        if($statement->rowCount() === 0) {
            //user does not exist
            return false;
        }
        return true; //update successful

    }


    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @return true if $email is an existing email address
     */
    public function exists($email) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$email]);

        if($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    /**
     * Create a new user
     * @param $email
     * @param $name
     * @param $password
     * @param $validator
     * @return string
     */
    public function add($email, $name, $password, $validator) {

        // Ensure we have no duplicate email address
        if($this->exists($email)) {
            return "Email address already exists.";
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, password, salt)
VALUES(?, ?, ?, ?)
SQL;

        $salt = self::randomSalt();
        $hash = hash("sha256", $password . $salt);

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([ $email, $name, $hash, $salt ]);

        return $pdo->lastInsertId();

    }

    /**
     * Send email verification email
     * @param $name
     * @param $email
     * @param Email $mailer
     * @return string
     */
    public function sendVerification($name, $email, Email $mailer) {

        // Ensure we have no duplicate email address
        if($this->exists($email)){
            return "Email address already exists.";
        }

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $salt = self::randomSalt();
        $validator = $validators->newValidator($name, $email, $salt);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/accountvalidation.php?v=' . $validator;

        $from = $this->site->getEmail();
        //$name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Light Em Up!. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($email, $subject, $message, $headers);


    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password) {
        $sql =<<<SQL
UPDATE $this->tableName
SET password=?, salt=?
WHERE id=?
SQL;
        $salt = self::randomSalt();
        $hash = hash("sha256", $password . $salt);

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($hash, $salt, $userid));

    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @return Salt string
     */
    public static function randomSalt($len = 16) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }




}
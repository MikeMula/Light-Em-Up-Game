<?php


namespace Lights;


class Validators extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }


    /**
     * Create a new validator and add it to the table.
     * @param $name User this validator is for.
     * @return The new validator.
     */
    public function newValidator($name, $email, $salt) {
        $validator = $this->createValidator();

        // Write to the table
        $sql=<<<SQL
INSERT INTO $this->tableName(validator, date, name, email, salt)
VALUES(?,?,?,?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $hashedValidator = hash("sha256", $validator.$salt);
        try {
            if($statement->execute(array($hashedValidator, date("Y-m-d H:i:s"), $name, $email, $salt)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $validator;
    }



    /**
     * Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @return Validator string
     */
    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    /**
     * Determine if a validator is valid. If it is,
     * return the name and email for that validator.
     * @param $email Validator to look up
     * @return array of name and email or null if not found.
     */
    public function get($email) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));

        if($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return array("name"=>$row['name'], "validator"=>$row['validator'], "salt"=>$row['salt']);
    }

    /**
     * Remove any validators for this email ID.
     * @param $email The USER EMAIL ID we are clearing validators for.
     */
    public function remove($email) {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));
    }

}
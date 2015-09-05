<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 18:14
 */

class DBUser {
    public $id;
    public $lastName;
    public $firstName;
    public $email;
    public $salt;
    public $hash;

    public $loaded;
    private $db;

    public function __construct($emailAddress)
    {
        $this->db = db::getInstance();
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        try{
            $s = $this->db->prepare($sql);
            $s->bindValue(":email", $emailAddress);
            $s->execute();
            $result = $s->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['userID'];
            $this->lastName = $result['lastName'];
            $this->firstName = $result['firstName'];
            $this->email = $result['email'];
            $this->salt = $result['salt'];
            $this->hash = $result['hash'];

            if(!isset($this->id) || !isset($this->lastName) || !isset($this->firstName) || !isset($this->email)|| !isset($this->salt)|| !isset($this->hash))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to load controller for id : $emailAddress  with error " . $e->getMessage());
            $this->loaded = false;
        }
    }

    public function create(){
        if(!isset($this->lastName) || !isset($this->firstName) || !isset($this->email)|| !isset($this->salt)|| !isset($this->hash))
        {
            echo "firstPArt";
            $this->loaded = false;
        }
        $tempUser = new DBUser($this->email);
        if($tempUser->loaded)
        {
            echo "secondPArt";
            new ErrorLog("attempt to save duplicate email address");
            $this->loaded = false;
        }
        $sql = "INSERT INTO users (lastName, firstName, email, salt, hash) values (:lname, :fname, :email, :salt, :hash)";

        try {
            $s = $this->db->prepare($sql);
            $s->bindValue(":email", $this->email);
            $s->bindValue(":lname", $this->lastName);
            $s->bindValue(":fname", $this->firstName);
            $s->bindValue(":salt", $this->salt);
            $s->bindValue(":hash", $this->hash);
            $s->execute();

            $this->loaded = true;

        }catch(PDOException $e)
        {
            echo $e->getMessage();
            new ErrorLog("Problem inserting into user into  database " . $this->email . " " . $this->lastName . " ". $this->firstName . " ". $this->salt . " ". $this->hash . " ");
            $this->loaded = false;
        }

    }
}

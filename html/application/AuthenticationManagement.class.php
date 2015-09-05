<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 01/09/15
 * Time: 17:52
 */
class AuthenticationManagement
{
    protected $email;
    protected $hashedPassword;
    protected $loggedIn = false;
    protected $password;

    protected $user;

    protected $db;

    public $loginError;

    public function __construct()
    {
        $this->db = db::getInstance();
    }

    public function is_logged_in(){
        if($this->loggedIn){
            return true;
        }
        session_start();
        if(isset($_SESSION['loggedin'])){
            $this->email = $_SESSION['email'];
            $this->hashedPassword = $_SESSION['hashedPassword'];
            return $this->Authenticated();
        }
        return false;
    }

    public function log_in($email, $password){
        $this->email = $email;
        $this->password = $password;
        if($this->Authenticated()){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $this->email;
            $_SESSION['hashedPassword'] = $this->hashedPassword;
            $this->loggedIn = true;
            return true;
        }else{
            $this->loginError = "Incorrect Username and Password";
            return false;
        }
    }

    public function log_out(){
        session_start();
        session_unset();
    }

    protected function Authenticated(){
        $this->user = new DBUser($this->email);
        if($this->user->loaded)
        {
            if(isset($this->hashedPassword) && $this->hashedPassword == $this->user->hash)
            {
                return true;
            }
            else if($this->user->hash == crypt($this->password, $this->user->salt)){
                //We've authenticated
                $this->hashedPassword = $this->user->hash;
                return true;
            }else{
                return false;
            }
        }
        else{
            new Log("User not found in DB" . $this->email);
            return false;
        }
    }
}
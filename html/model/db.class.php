<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:48
 *          The database utilises a singleton design pattern, this
 *          insures that only one connection to the db is used.
 */

class DB {
    private static $_instance;
    private $_db;
    private $username;
    private $password;
    private $database;

    public static function getInstance()
    {
        if(!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        //Obtaining config Details
        try{

            $config_file = parse_ini_file(__SITE_PATH . "/webdep.ini");

            $this->username = $config_file['username'];
            $this->password = $config_file['password'];
            $this->database = $config_file['database'];

            new Log("Obtained Database details : " . $this->username . " : " . $this->password . " : " . $this->database);

        } catch(Exception $e) {
            new ErrorLog("Failed to read config details from ini : " . $e);
            echo ("Failed to read config details from ini : " . $e);
            die();
        }

        //creating connection to the Database;
        try{
            $this->_db = new PDO("mysql:host=127.0.0.1;dbname=" . $this->database , $this->username, $this->password);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_db->exec('SET NAMES "utf8"');

            new Log("Obtained Database Connecton : " . $this->username . " : " . $this->password . " : " . $this->database);

        } catch (PDOException $ex) {
            new ErrorLog("Failed to create a connection to the Database : " . $ex);
            echo ("Failed to create a connection to the Database : " . $ex);
            die();
        }
    }

    public function __call($method, $args)
    {
        if ( is_callable(array($this->_db, $method)) ) {
            return call_user_func_array(array($this->_db, $method), $args);
        }
        else {
            throw new BadMethodCallException('Undefined method Database::' . $method);
        }
    }

    private function __clone(){}
}




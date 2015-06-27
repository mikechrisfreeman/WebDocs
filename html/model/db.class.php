<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:48
 *          The database utilises a singleton design pattern, this
 *          insures that only one connection to the db is used.
 */

class db {
    private static $_instance;
    private $_db;

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
        //TODO: Instantiate the connection used
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
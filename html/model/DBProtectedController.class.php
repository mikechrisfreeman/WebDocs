<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 01/09/15
 * Time: 18:42
 */

class DBProtectedController {
    public $id;
    public $name;
    public $loaded;
    public $redirect;
    private $db;

    public function __construct($name)
    {
        $this->db = db::getInstance();

        try{
            $sql = "SELECT * FROM ProtectedControllers WHERE name = '". $name."'";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['ID'];
            $this->name = $result['name'];
            $this->redirect = $result['redirect'];

            if(!isset($this->id) || !isset($this->name))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to load ProtectedController for id : $id  with error " . $e->getMessage());
            $this->loaded = false;
        }
    }
}

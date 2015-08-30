<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 18:14
 */

class CPType {
    public $id;
    public $CPtype;
    public $loaded;
    private $db;

    public function __construct($type)
    {
        $this->db = db::getInstance();
        try{
            $sql = "SELECT * FROM ControllerPluginTypes WHERE name = '". $type ."'";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['CPTypeID'];
            $this->CPtype = $result['name'];

            if(!isset($this->id) || !isset($this->CPtype))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to load plugin for name : $type with error " . $e->getMessage());
            $this->loaded;
        }
    }
}

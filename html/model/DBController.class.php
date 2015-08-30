<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 18:14
 */

class DBController {
    public $id;
    public $name;
    public $loaded;
    public $type;
    private $db;

    public function __construct($id)
    {
        $this->db = db::getInstance();

        try{
            $sql = "SELECT * FROM controllers WHERE controllerID = '". $id."'";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['controllerID'];
            $this->name = $result['name'];
            $this->type = $result['type'];

            if(!isset($this->id) || !isset($this->name) || !isset($this->type))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to load controller for id : $id  with error " . $e->getMessage());
            $this->loaded = false;
        }
    }
}

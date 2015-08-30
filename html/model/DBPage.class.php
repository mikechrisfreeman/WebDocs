<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 18:14
 */

class DBPage {
    public $id;
    public $name;
    public $loaded;
    private $db;

    public function __construct($id)
    {
        $this->db = db::getInstance();

        try{
            $sql = "SELECT * FROM pages WHERE pageID = '". $id."'";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['pageID'];
            $this->name = $result['name'];


            if(!isset($this->id) || !isset($this->name))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to load page for id : $id  with error " . $e->getMessage());
            $this->loaded = false;
        }
    }
}

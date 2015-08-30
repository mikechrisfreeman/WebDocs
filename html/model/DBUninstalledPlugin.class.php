<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 24/08/15
 * Time: 18:14
 */


class DBUninstalledPlugin {
    public $id;
    public $name;
    public $loaded;
    private $db;

    public function __construct($id)
    {
        $this->db = db::getInstance();

        try{
            $sql = "SELECT * FROM uninstalledplugins WHERE id = '". $id."'";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['ID'];
            $this->name = $result['name'];


            if(!isset($this->id) || !isset($this->name))
                $this->loaded = false;
            else
                $this->loaded = true;

        }catch(PDOException $e)
        {
            echo $e->getMessage();
            new ErrorLog("Unable to load uninstalled plugin for id : $id  with error " . $e->getMessage());
            $this->loaded = false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM uninstalledplugins where id = " . $this->id;
        try{
            $this->db->query($sql);

        }catch(Exception $e)
        {
            new ErrorLog("Unable to delete plugin : " . $this->name ." with id " .$this->id ." from tht eDB");
        }
    }

}



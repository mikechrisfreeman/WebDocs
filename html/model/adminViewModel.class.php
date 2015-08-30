<?php

class adminViewModel
{
    public $uninstalledPlugins = array();
    public $enabledPlugins = array();
    public $installedPlugins = array();

    public $db;

    public function __construct()
    {
        $this->db = db::getInstance();

        $this->getUninstalledPlugins();
        $this->getEnabledPlugins();
        $this->getInstalledPlugins();
    }

    private function getUninstalledPlugins()
    {
        try{
            $sql = "SELECT * FROM uninstalledPlugins";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $temp = new DBUninstalledPlugin($row['ID']);
                if($temp->loaded)
                    array_push($this->uninstalledPlugins, $temp);
            }

        }catch(PDOException $e)
        {
            new ErrorLog("Error getting uninstalled plugins, error : " . $e->getMessage());

        }
    }

    private function getEnabledPlugins()
    {
        try{
            $sql = "SELECT * FROM PagePluginController";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $temp = new DBPagePluginController($row['pageID'], $row['pluginID'], $row['controllerID']);
                if($temp->loaded)
                    array_push($this->enabledPlugins, $temp);
            }

        }catch(PDOException $e)
        {
            new ErrorLog("Error getting enabled plugins, error : " . $e->getMessage());
        }
    }

    private function getInstalledPlugins()
    {
        try{
            $sql = "SELECT * FROM plugins";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $temp = new DBPlugin($row['pluginID']);
                if($temp->loaded)
                    array_push($this->installedPlugins, $temp);
            }

        }catch(PDOException $e)
        {
            new ErrorLog("Error getting uninstalled plugins, error : " . $e->getMessage());

        }
    }
}
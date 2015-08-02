<?php

abstract class dataController extends controller
{
    //There can be a number of dataPlugins
    protected $pluginIDs = array();

    protected function checkForPlugins()
    {
        try{

            //Calling a Stored Procedure to get the pluginID for the controller
            $StoredProcedure = $this->db->prepare("CALL GetPluginIDForController(?, ?)");

            //We want to check that this page has a plugin
            $StoredProcedure->bindValue(1, 999, PDO::PARAM_INT);

            //We want to make sure that only this controller is checked
            $StoredProcedure->bindValue(2, get_class($this), PDO::PARAM_STR);

            $StoredProcedure->execute();

            new Log("Getting PluginID from check For Plugins, pageID =  " . 999 .  " class =  " . get_class($this));

            //Check if there are rows, if not return false
            if($StoredProcedure->rowCount() > 0)
            {
                $result = $StoredProcedure->fetchAll(PDO::FETCH_ASSOC);

                foreach($result as $row)
                {
                    array_push($this->pluginIDs, $row['pluginID']);
                }
                return true;
            }else
                return false;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to check checkPlugin in API class, error : " . $e->getMessage());
            return false;
        }
    }

    protected function executePlugin($pluginID, $args)
    {
        //we're in a dataController and will pass to a dataPlugin
        $link = "http://localhost/dataPlugin/";


        try{
            new Log("Getting Plugin Details from ExecutePlugin method, class =  " . get_class($this) . " for PluginID = " . $pluginID);

            //Calling a Stored Procedure to get the pluginID for the controller
            $StoredProcedure = $this->db->prepare("CALL GetPluginDetailsforID(?)");

            $StoredProcedure->bindValue(1, $pluginID, PDO::PARAM_INT);

            $StoredProcedure->execute();

            //Check if there are rows, if not return as there is nothing to execute
            if($StoredProcedure->rowCount() > 0)
            {
                $result = $StoredProcedure->fetch(PDO::FETCH_ASSOC);
                $this->plugin = $result['name'];
            }
            else
            {
                new Log("No rows for this plugin = ". $pluginID . "class =  " . get_class($this));
                return;
            }

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to execute checkPlugin in controller class, error : " . $e->getMessage());
        }

        //We have the details - now let the framework handle the instantiation
        new Log(" echoing file_get_contents, class =  " . get_class($this) . " for PluginID = " . $pluginID);

        echo file_get_contents($link . $this->plugin . "?data=" . implode(',', $args));
    }

    public function index()
    {
        //Return if the Table has not been specified
        if(!isset($_GET['table']))
            return;

        //Assigning the Post data to $inputData : Please note, arrays in PHP are assigned by copy, not reference.
        $inputData = $_POST;

        if($this->checkForPlugins())
        {
            foreach($this->pluginIDs as $pluginID)
            {
                $this->executePlugin($pluginID, $inputData);
            }
        }
        var_dump($inputData);
    }
}
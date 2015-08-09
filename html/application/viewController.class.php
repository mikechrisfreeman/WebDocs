<?php

abstract class viewController extends controller
{
    protected $pageID;
    protected $pluginID;
    private $pluginOverride;
    private $pluginAfter;

    public function __construct($registry)
    {
        Parent::__Construct($registry);
    }
    /**
     * @checkPlugin Checks to see if there is a plugin associated.
     * @return bool
     */
    protected function checkForPlugins()
    {
        try{

            //Calling a Stored Procedure to get the pluginID for the controller
            $StoredProcedure = $this->db->prepare("CALL GetPluginIDForController(?, ?)");

            //We want to check that this page has a plugin
            $StoredProcedure->bindValue(1, $this->pageID, PDO::PARAM_INT);

            //We want to make sure that only this controller is check
            $StoredProcedure->bindValue(2, get_class($this), PDO::PARAM_STR);
            $StoredProcedure->execute();

            new Log("Getting PluginID from check Plugin, pageID =  " . $this->pageID .  " class =  " . get_class($this));

            //Check if there are rows, if not return false
            if($StoredProcedure->rowCount() > 0)
            {
                $result = $StoredProcedure->fetch(PDO::FETCH_ASSOC);

                //We have a plugin, assign the ID pluginID variable.
                $this->pluginID = $result['pluginID'];
                return true;
            }else
                return false;

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to check checkPlugin in controller class, error : " . $e->getMessage());
            return false;
        }

    }

    /**
     * @executePlugin if plugin is present a plugin will be executed.
     */
    protected function executePlugin()
    {
        $link = "http://localhost/plugin/";


        try{
            new Log("Getting Plugin Details from ExecutePlugin method, class =  " . get_class($this) . " for PluginID = " . $this->pluginID);

            //Calling a Stored Procedure to get the pluginID for the controller
            $StoredProcedure = $this->db->prepare("CALL GetPluginDetailsforID(?)");

            $StoredProcedure->bindValue(1, $this->pluginID, PDO::PARAM_INT);

            $StoredProcedure->execute();

            //Check if there are rows, if not return as there is nothing to execute
            if($StoredProcedure->rowCount() > 0)
            {
                $result = $StoredProcedure->fetch(PDO::FETCH_ASSOC);
                $this->plugin = $result['name'];
                $this->pluginAfter = $result['after'];
                $this->pluginOverride = $result['override'];

            }else
            {
                new Log("Getting PluginID from check Plugin, pageID =  " . $this->pageID .  " class =  " . get_class($this));
                return;
            }

        }catch(PDOException $e)
        {
            new ErrorLog("Unable to execute checkPlugin in controller class, error : " . $e->getMessage());
        }

        //We have the details - now let the framework handle the instantiation
        new Log(" echoing file_get_contents, class =  " . get_class($this) . " for PluginID = " . $this->pluginID);
        echo file_get_contents($link . $this->plugin);
    }

    /*
    * Plugin execution logic - this is put in the abstract controller, so concrete controller can concentrate
    * on what they're supposed to do.
    */
    public function index($PageID)
    {
        $this->pageID = $PageID;
        if($this->checkForPlugins())
        {
            if($this->pluginOverride)
            {
                $this->executePlugin();
            }
            else
            {
                if($this->pluginAfter)
                {
                    $this->action();
                    $this->executePlugin();
                }
                else
                {
                    $this->executePlugin();
                    $this->action();
                }
            }
        }
        else
        {
            $this->action();
        }
    }

}
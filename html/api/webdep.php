<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 20/06/15
 * Time: 15:38
 */

class webdepAPI extends API
{
    public function index()
    {
        echo "Michael Was here";
    }


    public function getAvailablePagesForController($controllerId){
        $controller = new DBController($controllerId);

        $pages = array();

        if($controller->loaded)
        {
            $sql = "SELECT distinct pageID FROM pagecontroller WHERE controllerID = " . $controller->id . " AND pageid <>  '888'";
            try{
                $stmt = $this->db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $temp = new DBPage($row['pageID']);
                    if($temp->loaded)
                    {
                        array_push($pages, $temp);
                    }
                }
            }catch(PDOException $e)
            {
                new ErrorLog("Error loading pages for controller ID : " .$controllerId . " errror : " . $e->getMessage());
                $this->returnHTTPError(500, $e->getMessage());
            }
        }else{
            new ErrorLog("Error loading pages for controller ID : " .$controllerId);
            $this->returnHTTPError(500, "Error loading pages for controller ID : " . $controllerId);
        }
        echo json_encode($pages);
    }


    public function getAvailableControllersForPlugin($pluginId)
    {
        $plugin = new DBPlugin($pluginId);
        $controllers = array();
        if($plugin->loaded)
        {
            //We dont want the admin controllers
            $sql = "SELECT * FROM Controllers WHERE type = " . $plugin->type . " AND name NOT LIKE '%admin%'";
            try{
                $stmt = $this->db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $temp = new DBController($row['controllerID']);
                    if($temp->loaded)
                    {
                        array_push($controllers, $temp);
                    }
                }
            }catch(PDOException $e)
            {
                new ErrorLog("Error loading plugin for ID : " .$pluginId . " errror : " . $e->getMessage());
                $this->returnHTTPError(500, $e->getMessage());
            }
        }else{
            new ErrorLog("Error loading plugin for ID : " .$pluginId);
            $this->returnHTTPError(500, "Unable to load plugin for id " . $pluginId);
        }
        echo json_encode($controllers);
    }
    /*
     * This method scans all plugins in the plugin folder and checks whether they have been installed,
     * It populates the.
     */
    public function scanPlugins()
    {
        $pluginDirectory = __SITE_PATH . "/html/plugin/";
        $installedPlugins = $this->getAllInstalledPlugins();

        try {
            $files = scandir($pluginDirectory);

            foreach ($files as $key => $value) {
                if (!in_array($value, $installedPlugins)) {
                    //for every file - we get the name without the php extension
                    $uninstalledPluginName = substr($value, 0, strpos($value, "."));
                    {
                        //make sure we have a file
                        if ($uninstalledPluginName != null && strlen($uninstalledPluginName) > 0) {
                            if (!$this->depositUninstalledPlugin($uninstalledPluginName))
                                $this->returnHTTPError(500, "Error deposting plugin");
                        }
                    }
                }
            }

        } catch (Exception $E) {
            new ErrorLog("There has been an error scanning the directory");
            $this->returnHTTPError(500, "Error scanning directory : " . $pluginDirectory);
        }
    }

    public function getUninstalledPlugins()
    {
        $uPlugins = array();
        try{
            $sql = "SELECT * FROM UninstalledPlugins";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                array_push($uPlugins, $row);
            }
        }catch(PDOException $e)
        {
            new ErrorLog("Error getting uninstalledPlugins error : " . $e->getMessage() );
            $this->returnHTTPError(500, $e->getMessage());
        }
        echo json_encode($uPlugins);
    }

    /*
     * Install plugin method is a router for both the Data and View plugin installation
     * As this method is plubic facing webAPI - Appropriate httpresponse are sent in the headedr.
     */
    public function installPlugin($ID)
    {
        $install = 'install';
        $view = 'view';
        new Log("Attempting to install plugin with ID " . $ID);

        $uninstalledPlugin = new DBUninstalledPlugin($ID);
        if($uninstalledPlugin != null && class_exists($uninstalledPlugin->name))
        {
            $plugin = new $uninstalledPlugin->name($this->registry);
            if($plugin->PluginType == "view") {
                $this->installViewPlugin($plugin, $uninstalledPlugin->name);
            }
            elseif($plugin->PluginType == "data") {
                $this->installDataPlugin($plugin, $uninstalledPlugin->name);
            }else{
                $this->returnError(500, "Unknown Plugin - cant install");
            }

            //We then need to remove the plugin from the uninstalled plugins table;
            $uninstalledPlugin->delete();
        }
        else
        {
            new ErrorLog("There has been a problem installing plugin for ID " . $ID . " Error : Plugin does not exist");
            $this->returnHTTPError(500, "Plugin does not exist");
            return;
        }
    }

    /*
     * Used by the administration interface for enabling and disabling plugins
     */
    public function enablePlugin($controllerID, $pluginID, $pageID)
    {
        //We can only enable plugins that exist : the ORM mapping helps with this.
        $controller = new DBController($controllerID);
        $plugin = new DBPlugin($pluginID);
        $page = new DBPage($pageID);
        if($controller->loaded && $plugin->loaded && $page->loaded && $plugin->type == $controller->type)
        {
            $sql = "INSERT INTO PagePluginController (pageID, pluginID, controllerID) VALUES ('". $page->id ."','". $plugin->id."','". $controller->id ."')";
            try{
                $this->db->query($sql);
            }catch(PDOException $e) {
                new ErrorLog("There has been an error attempting an insert into the DB, error : " . $e->getMessage());
                new ErrorLog("SQL Query : " . $sql);
                $this->returnHTTPError(500, "Error installing plugin");
            }
        }
        else
        {
            new ErrorLog("Problem enabling plugin : Please look further up the log trail");
            $this->returnHTTPError(500, "Error installing plugin");
        }
    }

    /*
        * Used by the administration interface for enabling and disabling plugins
    */
    public function disablePlugin($controllerID, $pluginID, $pageID)
    {
        //We can only disable plugins that exist : the ORM mapping helps with this.
        $controller = new DBController($controllerID);
        $plugin = new DBPlugin($pluginID);
        $page = new DBPage($pageID);
        if($controller->loaded && $plugin->loaded && $page->loaded)
        {
            $sql = "DELETE FROM PagePluginController WHERE controllerID = '" . $controller->id . "' AND pageID = '" . $page->id . "' AND pluginID = '" . $plugin->id . "'";
            try{
                $this->db->query($sql);
            }catch(PDOException $e) {
                new ErrorLog("There has been an error attempting an insert into the DB, error : " . $e->getMessage());
                new ErrorLog("SQL Query : " . $sql);
                $this->returnHTTPError(500, "Error installing plugin");
            }
        }
        else
        {
            new ErrorLog("Problem enabling plugin : Please look further up the log trail");
            $this->returnHTTPError(500, "Error installing plugin");
        }
    }


    private function installViewPlugin($plugin, $pluginName)
    {
        if(!$plugin->install())
        {
            new ErrorLog("Unable to process the install function of plugin = " . $pluginName . " with error = ");
            $this->returnHTTPError(500, "plugin install failed.");
        }
        //Now moving the view to the correct place - if view exists for plugin
        if($plugin->view != null)
        {

            if(file_exists(($plugin->view)))
            {
                //View property is a file location, moving the file
                try{
                    mkdir(__SITE_PATH . "/html/views/" . $pluginName);
                    rename($plugin->view, __SITE_PATH . "/html/views/" . $pluginName ."/index.php");
                }catch(Exception $e)
                {
                    new ErrorLog("Unable to create Directory for view for plugin = " . $pluginName . " with error = " . $e->getMessage());
                    $this->returnHTTPError(500, $e->getMessage());
                }

            }
            else
            {
                try{
                    mkdir(__SITE_PATH . "/html/views/" . $pluginName);
                    $pluginView = fopen( __SITE_PATH . "/html/views/" . $pluginName ."/index.php", "w");
                    fwrite($pluginView, $plugin->view);

                }catch(Exception $e)
                {
                    new ErrorLog("Unable to create Directory for view for plugin = " . $pluginName . " with error = " . $e->getMessage());
                    $this->returnHTTPError(500, $e->getMessage());
                }
            }
        }
        //finally - update database of installed plugin
        $pluginType = new CPType("VIEW");
        if($pluginType->loaded && $this->depositInDB($pluginName, $pluginType->id, $plugin->override, $plugin->after)) {
            new Log("Successfully installed plugin");
        }else{
            new ErrorLog("Error in install view plugin - please see earlier logs");
            $this->returnHTTPError(500, "View Plugin install Failed");
        }

    }

    private function installDataPlugin($plugin, $pluginName)
    {
        //finally - update database of installed plugin
        $pluginType = new CPType("DATA");
        if($pluginType->loaded && $this->depositInDB($pluginName, $pluginType->id, $plugin->override, $plugin->after)) {
            new Log("Successfully installed plugin " . $pluginName);
        }else{
            new ErrorLog("Error in install view plugin - please see earlier logs");
            $this->returnHTTPError(500, "View Plugin install Failed");
        }
    }

    /*
     * This private function is bot the install plugin functions
     */
    private function depositInDB($pluginName, $typeID, $override, $after)
    {
        try{
            $StoredProcedure = $this->db->prepare("CALL InstallPlugin(?, ?, ?, ?)");

            $StoredProcedure->bindValue(1, $pluginName, PDO::PARAM_INT);
            $StoredProcedure->bindValue(2, $typeID, PDO::PARAM_INT);
            $StoredProcedure->bindValue(3, $override, PDO::PARAM_INT);
            $StoredProcedure->bindValue(4, $after, PDO::PARAM_INT);

            $StoredProcedure->execute();

            return true;

        }catch(PDOException $e)
        {
            new ErrorLog("An error has occured depositing plugin details into dB for plugin : " . $pluginName . " in the plugin class error : " . $e->getMessage());
            return false;
        }
    }

    private function getAllInstalledPlugins()
    {
        $installedPlugins = array();
        try{
            $sql = "SELECT * FROM plugins";
            $stmt = $this->db->query($sql);
            $dbVal =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($dbVal as $val)
            {
                array_push($installedPlugins, $val['name']);
            }
        }
        catch(PDOException $e)
        {
            new ErrorLog("Unable to get all installed plugins");
        }

        return $installedPlugins;
    }

    private function depositUninstalledPlugin($uplugin){
        try{
            $StoredProcedure = $this->db->prepare("CALL depositUninstalledPlugin(?)");

            $StoredProcedure->bindValue(1, $uplugin, PDO::PARAM_INT);

            $StoredProcedure->execute();

            return true;

        }catch(PDOException $e){
            new ErrorLog("Unable to deposit new plugin" . $e->getMessage());
            return false;
        }
    }
}
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

    public function installPlugin($pluginName)
    {
        echo $pluginName;
        $install = 'install';
        $view = 'view';
        new Log("Attempting to install plugin " . $pluginName);
        try{
            //instantiate the plugin
            $plugin = new $pluginName($this->registry);
            if($plugin->PluginType== "view") {
                return $this->installViewPlugin($plugin, $pluginName);
            }
            elseif($plugin->PluginType == "data") {
                return $this->installDataPlugin($plugin, $pluginName);
            }else{
                return $this->returnError("Unknown Plugin - cant install");
            }

        }catch(Exception $e)
        {
            new ErrorLog("There has been a problem installing plugin " . $pluginName . " Error : " . $e->getMessage());
        }
    }

    private function installViewPlugin($plugin, $pluginName)
    {
        try{
            //Processing DB commands if they exist.
            $plugin->install();
        }catch(Exception $e)
        {
            new ErrorLog("Unable to process the install of plugin = " . $pluginName . " with error = " . $e->getMessage());
        }

        //Now moving the view to the correct place - if view exists for plugin
        if($plugin->view != null)
        {

            if(file_exists(($plugin->view)))
            {
                //View property is a file location, moving the file
                try{
                    mkdir(__SITE_PATH . "/html/views/" . $pluginName);
                    rename($plugin->view, __SITE_PATH . "html/views/" . $pluginName ."/index.php");
                }catch(Exception $e)
                {
                    new ErrorLog("Unable to create Directory for view for plugin = " . $pluginName . " with error = " . $e->getMessage());
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
                }
            }
        }
    }

    private function installDataPlugin($plugin, $pluginName)
    {
        echo "found view plugin for install";
    }

    // I need to think about good responses with jquery
    private function returnHTTPOK()
    {

    }

    private function returnError($error)
    {
        echo $error;
    }
}
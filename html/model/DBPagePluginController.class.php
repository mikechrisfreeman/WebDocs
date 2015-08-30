<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 29/08/15
 * Time: 15:44
 */

class DBPagePluginController {

    public $page;
    public $controller;
    public $plugin;

    public $loaded = false;

    public function __construct($pageID,  $pluginID, $controllerID)
    {
        $this->page = new DBpage($pageID);
        $this->plugin = new DBPlugin($pluginID);
        $this->controller = new DBController($controllerID);

        if($this->page->loaded && $this->plugin->loaded && $this->controller->loaded)
            $this->loaded = true;

    }

}
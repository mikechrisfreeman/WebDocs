<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 01/08/15
 * Time: 15:51
 */

abstract class viewPlugin extends Plugin
{
    public $PluginType = "view";
    public $view = false;
    public $override = false;
    public $after = false;

    abstract function install();
    abstract function index();
}
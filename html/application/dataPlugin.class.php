<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 01/08/15
 * Time: 15:51
 */

abstract class dataPlugin extends Plugin
{
    public $PluginType = "data";
    public $override = false;
    public $after = false;

    /*
     * Method accepts an array as a parameter and returns array
     */
    abstract function index($args);
}
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
    abstract function index($args);
}
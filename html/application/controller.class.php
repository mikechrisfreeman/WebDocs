<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:36
 * Description: Base controller class
 */

abstract class controller extends instantiator
{
    protected $plugin;

    abstract function action();
}
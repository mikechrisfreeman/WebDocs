<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 09/08/15
 * Time: 12:19
 */
class commentform extends viewPlugin
{
    public $view = "Michael Was here";
    public $override = false;
    public $after = false;

    public function install()
    {
        echo "I'm here";
    }
    public function index()
    {
        $this->registry->view->show(__CLASS__, 'index');
    }
}
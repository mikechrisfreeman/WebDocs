<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 20/06/15
 * Time: 15:38
 */

class homeController extends controller
{
    public function index()
    {
        $this->registry->view->welcome = 'Welcome';
        $this->registry->view->show(__CLASS__, 'index');
    }
}
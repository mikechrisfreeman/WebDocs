<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 20/06/15
 * Time: 15:38
 */

class blogController extends controller
{
    public function index()
    {
        $this->registry->view->title = 'blog index';
        $this->registry->view->show(__CLASS__,'index');
    }

    public function view()
    {
        $this->registry->view->title = 'blog View';
        $this->registry->view->show(__CLASS__,'index');
    }
}
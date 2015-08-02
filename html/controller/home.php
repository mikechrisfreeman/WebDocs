<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 20/06/15
 * Time: 15:38
 */

class homeController extends viewController
{
    public function action()
    {

        $this->registry->view->welcome = 'Welcome';
        $this->registry->view->pageNumber = $this->pageID;
        $this->registry->view->show(__CLASS__, 'index');
    }
}
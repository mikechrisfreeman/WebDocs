<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 29/08/15
 * Time: 09:48
 */

class adminController extends viewController{

    public function action()
    {
        $this->registry->view->pageNumber = $this->pageID;
        $this->registry->view->show(__CLASS__, 'index');
    }
}
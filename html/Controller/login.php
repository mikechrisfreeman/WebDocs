<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 03/09/15
 * Time: 13:24
 */
class loginController extends viewController{

    public $returnAddress;

    public function action(){
        $this->registry->view->welcome = 'Welcome';
        $this->registry->view->pageNumber = $this->pageID;
        if(isset($_GET['returnAddress'])){
            $this->registry->view->returnAddress =  $_GET['returnAddress'];
        }
        $this->registry->view->show(__CLASS__, 'index');
    }

    public function logUserIn(){
        $authMan = new AuthenticationManagement();
        if($authMan->log_in($_POST['email'], $_POST['pwd']))
        {
            header("Location: " . $_GET['redirectLink']);
            die();
        }else{
            echo "incorrect password";
            die();
        }
        die();
    }
}
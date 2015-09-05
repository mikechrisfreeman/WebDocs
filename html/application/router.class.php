<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:37
 */

class router
{
    /*
     * The Registry
     */
    private $registry;

    private $path;

    private $file;

    private $AuthMan;

    /**
     * @var This is the type of the Instantiator
     */
    private $type;

    /*
     * this is the Controller/Plugin/API that will be instantiated
     */
    private $instantiator;

    /**
     * @var this is the method of the Instantiator that will be called
     */
    private $method;

    /**
     * @param $registry
     */
    private $parameter1;
    private $parameter2;
    private $parameter3;



    function __construct($registry){
        $this->registry = $registry;
    }

    public function load()
    {
        $this->getInstantiator();
        switch(strtolower($this->type))
        {
            case 'dataplugin':
            case 'viewplugin':
            case 'actionplugin':
            case 'plugin' :
                $this->setPath(__SITE_PATH . "/html/plugin/");
                $this->file = $this->path . '/'. $this->instantiator . ".php";
                break;
            case 'api' :
                $this->setPath(__SITE_PATH . "/html/api/");
                $this->file = $this->path . '/'. $this->instantiator . ".php";
                break;
            case 'datacontroller':
            case 'viewcontroller':
            case 'controller' :
                $this->setPath(__SITE_PATH . "/html/controller");
                $this->file = $this->path . '/'. $this->instantiator . ".php";
                break;
        }
        $this->loadInstantiator();
    }

    private function loadInstantiator()
    {
        if(is_readable($this->file) == false)
        {
            die('404 Not Found');
        }
        include $this->file;
        switch($this->type)
        {
            case 'dataplugin':
            case 'viewplugin':
            case 'actionplugin':
            case 'plugin' :
                $class = $this->instantiator;
                break;
            case 'api' :
                $class = $this->instantiator . 'API';
                break;
            case 'datacontroller':
            case 'viewcontroller':
            case 'controller' :
                $class = $this->instantiator . 'Controller';
                break;
            case 'admin' :
                //perform some work here.
                break;
        }
        if(!isset($class))
        {
            die('404 Not Found');
        }
        $this->AuthMan = new AuthenticationManagement();
        $protectedController = new DBProtectedController($class);
        if($protectedController->loaded && !$this->AuthMan->is_logged_in())
        {
            //We redirect for some protected controllers but not for others - this is specified in the database
            if($protectedController->redirect)
            {
                //We need to redirect the user to the login page
                echo file_get_contents("http://$_SERVER[HTTP_HOST]/controller/login/index/777?returnAddress='". "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ."''");
                die();
//                $instantiator->returnAddress = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            }else{
                //edit the header here
            }
        }else{
            $instantiator = new $class($this->registry);
        }


        if (is_callable(array($instantiator, $this->method)) == false) {
            $method = 'index';
        } else {
            $method = $this->method;
        }

        if(isset($this->parameter1))
        {
            if(isset($this->parameter2))
            {
                if(isset($this->parameter3))
                    $instantiator->$method($this->parameter1, $this->parameter2, $this->parameter3);
                else
                    $instantiator->$method($this->parameter1, $this->parameter2);
            }else
            {
                $instantiator->$method($this->parameter1);
            }
        }else
        {
            $instantiator->$method();
        }
    }

    private function getInstantiator()
    {
        $route = (empty($_GET['request'])) ? '' : $_GET['request'];
        $parts = explode('/', $route);

        //If route is empty - or if there isn't sufficient amount of parameters
        if(empty($route) || count($parts) < 2)
        {
            $this->type = "controller";
            $this->instantiator = 'home';
            $this->method = 'index';
            $this->parameter1 = 1;
        }
        else
        {
            $this->type = $parts[0];
            $this->instantiator = $parts[1];

            //admin controller has a particular page number
            if(strtolower($this->instantiator) == 'admin'){
                $parts[3] = '888';
            }
            if(isset($parts[2])) {
                $this->method = $parts[2];
            }

            if(isset($parts[3]))
            {
                $this->parameter1 = $parts[3];
            }
            if(isset($parts[4]))
            {
                $this->parameter2 = $parts[4];
            }
            if(isset($parts[5]))
            {
                $this->parameter3 = $parts[5];
            }

        }
        if(empty($this->instantiator))
        {
            $this->instantiator = 'home';
        }

        if(empty($this->method))
        {
            $this->method = 'index';
        }
    }


    private function setPath($path) {

        /*** check if path i sa directory ***/
        if (is_dir($path) == false)
        {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        /*** set the path ***/
        $this->path = $path;
    }
}
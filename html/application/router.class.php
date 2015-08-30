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

    private $args = array();

    private $file;

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

        $instantiator = new $class($this->registry);


        if(is_callable(array($instantiator, $this->method)) == false)
        {
            $method = 'index';
        }
        else
        {
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

        //If route is empty - set the defaults for the home controller.
        if(empty($route))
        {
            $this->type = "controller";
            $route = 'index';
            $this->parameter1 = 1;
        }
        else
        {
            $parts = explode('/', $route);
            if (isset($parts[0]))
            {
                $this->type = $parts[0];
            }
            if (isset($parts[1]))
            {
                $this->instantiator = $parts[1];
                if(strtolower($this->instantiator) == 'admin'){
                    //assign the page number
                    $parts[3] = '888';
                }

            }
            if (isset($parts[2]))
            {
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

            //HardCo
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
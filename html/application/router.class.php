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

    function __construct($registry){
        $this->registry = $registry;
    }

    public function load()
    {
        $this->getInstantiator();
        switch(strtolower($this->type))
        {
            case 'plugin' :
                $this->setPath(__SITE_PATH . "/html/plugin/");
                $this->file = $this->path . '/'. $this->instantiator . ".php";
                break;
            case 'api' :
                $this->setPath(__SITE_PATH . "/html/api/");
                $this->file = $this->path . '/'. $this->instantiator . ".php";
                break;
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
        switch(strtolower($this->type))
        {
            case 'plugin' :
                $class = $this->instantiator . 'Plugin';
                break;
            case 'api' :
                $class = $this->instantiator . 'API';
                break;
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
        $instantiator->$method();
    }

    private function getInstantiator()
    {
        $route = (empty($_GET['request'])) ? '' : $_GET['request'];
        if(empty($route))
        {
            $this->type = "Controller";
            $route = 'index';
        }
        else
        {
            $parts = explode('/', $route);
            $this->type = $parts[0];
            $this->instantiator = $parts[1];
            if (isset($parts[2]))
            {
                $this->method = $parts[2];
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
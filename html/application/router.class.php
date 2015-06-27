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

    /*
     * the controller to handle the request
     */
    private $path;

    //Not sure what this is used for
    private $args = array();

    public $file;

    /*
     * this is the controller that will be called
     */
    public $controller;

    public $method;

    function __construct($registry){
        $this->registry = $registry;
    }

    public function load()
    {
        $this->getController();

        if(is_readable($this->file) == false)
        {
            die('404 Not Found');
        }
        include $this->file;
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        $method = '';
        if(is_callable(array($controller, $this->method)) == false)
        {
            $method = 'index';
        }
        else
        {
            $method = $this->method;
        }
        $controller->$method();
    }

    private function getController()
    {
        $route = (empty($_GET['request'])) ? '' : $_GET['request'];
        if(empty($route))
        {
            $route = 'index';
        }
        else {
            $parts = explode('/', $route);
            $this->controller = $parts[0];
            if (isset($parts[1])) {
                $this->method = $parts[1];
            }
        }
        if(empty($this->controller))
        {
            $this->controller = 'home';
        }

        if(empty($this->method))
        {
            $this->method = 'index';
        }

        $this->file = $this->path .'/'.$this->controller. '.php';
    }
    public function setPath($path) {

        /*** check if path i sa directory ***/
        if (is_dir($path) == false)
        {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        /*** set the path ***/
        $this->path = $path;
    }
}
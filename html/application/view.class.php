<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:37
 */

class view
{

    private $vars = array();

    /**
     * Magic method for setting variables in the template class
     * @param $index
     * @param $value
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * Magic method for getting variables from the template class
     * @get undefined vars
     * @param string $index
     * @return mixed
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }


    /**
     * @param $name is the name of the html page to be displayed.
     * @return bool if it cant be found an error is thrown.
     * @throws Exception is thrown if html file can not be found.
     */
    function show($controller, $name) {
        $path = __SITE_PATH . '/html/views' . '/' . $controller . '/' .$name . '.php';

        if (file_exists($path) == false)
        {
            throw new Exception('Unable to load view, file not found '. $path);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value)
        {
            $$key = $value;
        }

        include ($path);
    }
}
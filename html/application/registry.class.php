<?php
/**
 * User: mike
 * Date: 14/06/15
 * Time: 10:40
 *          The Registry is a class for site wide global variables.
 *          It's used so that the global namespace is not muddied.
 */

class Registry {

    //variable type array
    private $vars = array();

    //magic method to set array
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    //magic method to get array
    public function __get($index)
    {
        return $this->vars[$index];
    }

}
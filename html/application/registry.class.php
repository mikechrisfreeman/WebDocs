<?php
/**
 * User: mike
 * Date: 14/06/15
 * Time: 10:40
 *          The Registry is a class for site wide global variables.
 *          It's used so that the global namespace is not muddied.
 */

class Registry {

    /**
     * @the $vars array
     * @access private
     */
    private $vars = array();

    /**
     * @set undefined vars
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * @get undefined vars
     * @param string $index
     * @return mixed
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }

}
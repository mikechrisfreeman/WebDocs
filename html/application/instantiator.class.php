<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 27/06/15
 * Time: 15:11
 */

abstract class instantiator
{

    /*
    * Registry object that will be available to all constructors that inherit this class
    */

    protected $registry;

    function __construct($reg)
    {
        $this->registry = $reg;
    }

    /*
     * This framework specifies that all objects must have an index.
     */
    abstract function index();
}
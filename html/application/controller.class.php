<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:36
 * Description: Base controller class
 */

abstract class controller
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
     * The framework specifies that all constructors are required to implement and index method
     * This is the default method that is called if one is not specified.
     */
    abstract function index();
}
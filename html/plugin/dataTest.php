<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 29/07/15
 * Time: 18:29
 */

class dataTest extends dataPlugin
{
    public function index($args)
    {
        echo "In the Data Plugin";
        return $args;
    }
}

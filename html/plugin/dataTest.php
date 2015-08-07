<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 29/07/15
 * Time: 18:29
 */

class dataTestPlugin extends Plugin
{
    public function index($args)
    {
        //We need to return a string
        echo implodeAssoc(',', $args);
    }
}

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
        new Log("In the index of the dataplugin test getting data : " . $args);
        echo "Michael was Here with data = " . $args;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 29/07/15
 * Time: 18:29
 */

class test extends viewPlugin
{
    public $view = "<h1>Testing</h1>";
    public function install()
    {

    }
    public function index()
    {
        ?>
            <h1>This is from the Index method of a plugin</h1>
        <?php
    }
}

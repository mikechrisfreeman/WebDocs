<?php
/**
 * User: mike
 * Date: 14/06/15
 * Time: 10:21
 * Description: Initial Script used to initialise the web application.
 *              The file includes the controller base , registry, router, view, api and instantiator classes.
 *              Sets the autoload function and specifies directories to look in.
 */

include __SITE_PATH . '/html/application/instantiator.class.php';
include __SITE_PATH . '/html/application/controller.class.php';
include __SITE_PATH . '/html/application/registry.class.php';
include __SITE_PATH . '/html/application/router.class.php';
include __SITE_PATH . '/html/application/view.class.php';
include __SITE_PATH . '/html/application/api.class.php';
include __SITE_PATH . '/html/model/db.class.php';
include __SITE_PATH . '/html/application/log.class.php';
include __SITE_PATH . '/html/application/errorlog.class.php';
include __SITE_PATH . '/html/application/plugin.class.php';
include __SITE_PATH . '/html/application/dataPlugin.class.php';
include __SITE_PATH . '/html/application/viewPlugin.class.php';
include __SITE_PATH . '/html/application/viewController.class.php';
include __SITE_PATH . '/html/application/dataController.class.php';
include __SITE_PATH . '/html/includes/functions.php';


/**
 * @param $class_name
 * @return bool
 *          This is a magic method that autoloads the class files
 *          it saves having to include the files everytime they are used
 */

function __autoload($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    $Modelfile = __SITE_PATH . '/html/model/' . $filename;
    $Pluginfile = __SITE_PATH . '/html/plugin/' . $class_name . '.php';

    if(file_exists($Modelfile))
    {
        include($Modelfile);

    }elseif(file_exists($Pluginfile))
    {
        include($Pluginfile);

    }else{
        return false;
    }
}


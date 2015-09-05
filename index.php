<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 14/06/15
 * Time: 10:07
 * Description: Entry Point for WebDep, sets a site wide constant for the document path and includes the initial scripts
 */

/*** Turning on Error Reporting ***/
error_reporting(E_ALL);

/*** Document Path Constant ***/
$site_location = realpath(dirname(__FILE__));
define('__SITE_PATH', $site_location);

/*** including initial scripts ***/
include 'html/includes/initial.php';

//declaring the registry that will be use by the framework.
$reg = new Registry();

//declaring the View that will be used by the framework.
$reg->view = new view();

//Getting an instance of the DB for the framework.
$reg->db = db::getInstance();

$reg->router = new router($reg);
$reg->router->load();


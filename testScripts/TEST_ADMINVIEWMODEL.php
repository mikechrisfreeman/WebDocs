<?php

/*** Turning on Error Reporting ***/
error_reporting(E_ALL);

/*** Document Path Constant ***/
$site_location = realpath(dirname(__FILE__));
define('__SITE_PATH', '/Users/mike/Webdocs');

/*** including initial scripts ***/
include '../html/includes/initial.php';

$test = new adminViewModel();
var_dump($test);
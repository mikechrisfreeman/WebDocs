<?php

/*** Turning on Error Reporting ***/
error_reporting(E_ALL);

/*** Document Path Constant ***/
$site_location = realpath(dirname(__FILE__));
define('__SITE_PATH', '/Users/mike/Webdocs');

/*** including initial scripts ***/
include '../html/includes/initial.php';

$password = "gf45_gdf#4hg";
$email = "mike.c.freeman@gmail.com";
$user = new User();
if($user->log_in($email, $password))
{
    echo "boom";
}
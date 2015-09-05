<?php

/*** Turning on Error Reporting ***/
error_reporting(E_ALL);

/*** Document Path Constant ***/
$site_location = realpath(dirname(__FILE__));
define('__SITE_PATH', '/Users/mike/Webdocs');

/*** including initial scripts ***/
include '../html/includes/initial.php';

$dbuser = new DBUser("mike.c.freeman@gmail.com");
$dbuser->firstName = "Michael";
$dbuser->lastName = "Freeman";
$dbuser->email = "mike.c.freeman@gmail.com";
$dbuser->salt = "This is just a test";
$dbuser->hash = crypt("Tabliering1208", $dbuser->salt);

$dbuser->create();
echo assert($dbuser->loaded);


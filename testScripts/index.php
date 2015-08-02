<?php

/*** Turning on Error Reporting ***/
error_reporting(E_ALL);

/*** Document Path Constant ***/
$site_location = realpath(dirname(__FILE__));
define('__SITE_PATH', '/Users/mike/Webdocs');

/*** including initial scripts ***/
include '../html/includes/initial.php';

$db = db::getInstance();

$Stm = $db->prepare("CALL GetPluginIDForController(?, ?)");
$Stm->bindValue(1, 1, PDO::PARAM_INT);
$Stm->bindValue(2, 'homeController', PDO::PARAM_STR);
$Stm->execute();
$result = $Stm->fetch(PDO::FETCH_ASSOC);
echo $result['pluginID'];

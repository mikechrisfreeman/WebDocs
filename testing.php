<?php
//
///*** Turning on Error Reporting ***/
//error_reporting(E_ALL);
//
///*** Document Path Constant ***/
//$site_location = realpath(dirname(__FILE__));
//define('__SITE_PATH', $site_location);
//
///*** including initial scripts ***/
//include 'html/includes/initial.php';
//
//
//try {
//    $db = DB::getInstance();
//    foreach($db->query('SELECT * FROM testing') as $row) {
//        echo $row['id'].' '.$row['name'];
//    }
//}catch(PDOException $E)
//{
//    echo $e;
//}

echo exec('whoami');

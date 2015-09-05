<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 01/09/15
 * Time: 18:24
 */
$password = 'gf45_gdf#4hg';
$cost = 10;
$salt = "Michael";
$hash = crypt($password, $salt);
echo $hash;
echo crypt($password, $salt);
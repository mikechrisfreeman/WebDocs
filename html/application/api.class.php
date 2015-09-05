<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 27/06/15
 * Time: 15:21
 */

abstract class api extends instantiator
{
    abstract function index();

    protected function returnHTTPError($code, $message)
    {
        header('Content-Type: application/json');
        header("HTTP/1.1 $code");
        die(json_encode(['code' => $code, 'message' => $message]));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 26/07/15
 * Time: 11:21
 */

class ErrorLog{
    public function __construct($message) {

        $filepath =__SITE_PATH . "/logs/ErrorLogs.txt";
        $date = new DateTime('now', new DateTimeZone('Europe/London'));
        $newMessage = $date->format('Y-m-d');
        $newMessage = $newMessage . "   :   " . $message . "\r\n";

        //dump log to file;
        file_put_contents($filepath, $newMessage, FILE_APPEND);
    }


}


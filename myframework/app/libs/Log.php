<?php

/*
 * Log
 */

class Log
{

    function __construct()
    {

    }

    public function log($messenger)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (is_dir('../log')) {
            if (file_exists('../log/log.txt')) {
                $file = fopen('../log/log.txt', 'a+');
                fwrite($file, date('d/m/Y H:i:s') . ': ' . $messenger . "\r\n");
                fclose($file);
            } else {
                $path = tempnam('../log', '');
                $file = fopen($path, 'w');
                fclose($file);
                rename($path, "../log/log.txt");
                $this->log($messenger);
            }
        } else {
            mkdir('../log');
            $this->log($messenger);
        }
    }
}
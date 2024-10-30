<?php

namespace CheckoutChamp\Includes\Logger;


class LoggerManager
{
    public static function log($message, $from = 'CheckoutChamp',$line = null)
    {
        try {

            $plugin_root = __DIR__ . '/logs/';
            $now = new \DateTime();
            $log_file = $plugin_root . 'log_' . $now->format('Y-m-d') . '.txt';
            $log_content = $now->format('Y-m-d H:i:s') . ' - ' . $from . ' - ' . $message . ' - ' . $line . PHP_EOL;

            if (!file_exists($log_file)) {
                $created = file_put_contents($log_file, $log_content);             
            } else {
                $written = file_put_contents($log_file, $log_content, FILE_APPEND);          
            }
        } catch (\Exception $e) {
        }
    }
}

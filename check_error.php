<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get Apache error log if accessible
$apache_log = error_log("test");
echo "Apache Error Log: " . $apache_log . "\n";

// Check Laravel log
$laravel_log = file_get_contents(__DIR__ . '/../storage/logs/laravel.log');
echo "Laravel Log:\n" . $laravel_log;
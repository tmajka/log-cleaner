<?php
return [
    // set log source to clean 'db' or 'file'
    'log_storage' => 'file',
    'file' => [
        // add absolute path to logs file
        'path' => '/home/elo/Sites/log-cleaner/var/log/system.log',
    ],
    'db' => [
        // add credential do db
        'host' => 'localhost:3306',
        'dbname' => 'magento',
        'username' => 'magento',
        'password' => 'magento',
        'table' => 'system_log'
    ],
];

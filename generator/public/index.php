<?php

if (! file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo 'Missing autoload file !';
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

\Website\Routing::manageRouting();

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = 'true';

// ย้าย Storage Path และ View Compiled Path ไปที่ /tmp
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// ย้าย Bootstrap Cache ไปที่ /tmp (แก้ปัญหา bootstrap/cache must be writable)
$_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/routes.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/events.php';

// บังคับเปลี่ยน Log Channel ให้พ่นออก stderr สำหรับ Serverless
$_ENV['LOG_CHANNEL'] = 'stderr';

$directories = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/bootstrap',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo '<h1>Laravel Fatal Error</h1>';
    echo '<p><b>Message:</b> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><b>File:</b> ' . htmlspecialchars($e->getFile()) . ' on line ' . $e->getLine() . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
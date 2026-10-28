<?php

// กำหนดโฟลเดอร์สำหรับเก็บ Storage/Cache ไว้ที่ /tmp สำหรับ Serverless
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}
if (!is_dir('/tmp/storage/framework/sessions')) {
    mkdir('/tmp/storage/framework/sessions', 0755, true);
}
if (!is_dir('/tmp/storage/framework/cache')) {
    mkdir('/tmp/storage/framework/cache', 0755, true);
}

require __DIR__ . '/../public/index.php';
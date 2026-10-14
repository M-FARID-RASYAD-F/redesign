<?php

// Ensure writable directories exist in serverless /tmp
$dirs = [
    '/tmp/views',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Copy seeded sqlite database to writable /tmp if using sqlite
if (!file_exists('/tmp/database.sqlite') && file_exists(__DIR__ . '/../database/database.sqlite')) {
    copy(__DIR__ . '/../database/database.sqlite', '/tmp/database.sqlite');
}

// Forward Vercel requests to Laravel's public entry point
require __DIR__ . '/../public/index.php';

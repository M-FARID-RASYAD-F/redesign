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
$srcDb = __DIR__ . '/../database/database.sqlite';
$dstDb = '/tmp/database.sqlite';

if (file_exists($srcDb)) {
    if (!file_exists($dstDb) || filesize($dstDb) !== filesize($srcDb)) {
        if (@copy($srcDb, $dstDb)) {
            error_log("INFO: database.sqlite successfully synced to /tmp (" . filesize($dstDb) . " bytes)");
        } else {
            error_log("ERROR: failed to copy database.sqlite to /tmp");
        }
    }
} else {
    error_log("WARNING: Source database not found at " . $srcDb);
}

// Forward Vercel requests to Laravel's public entry point
require __DIR__ . '/../public/index.php';

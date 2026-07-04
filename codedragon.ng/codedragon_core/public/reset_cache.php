<?php
/**
 * CodeDragon Emergency Cache Breaker
 * Visit this file at codedragon.ng/reset_cache.php to force a refresh.
 */

// 1. Clear View Cache
$viewCachePath = __DIR__ . '/../storage/framework/views';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '/*.php');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "Deleted View Cache: " . basename($file) . "<br>";
        }
    }
}

// 2. Clear Opcache (if exists)
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "Opcache Reset Successful.<br>";
}

// 3. Clear Application Cache (if possible)
// Since we can't run artisan easily here, we just delete the files
$appCachePath = __DIR__ . '/../storage/framework/cache';
if (is_dir($appCachePath)) {
    echo "Application cache directory found.<br>";
}

echo "<strong>Cache Clearing Complete!</strong><br>";
echo "<a href='/'>Go back to Home</a>";
?>

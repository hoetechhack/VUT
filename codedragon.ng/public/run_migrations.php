<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

// Load Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>CodeDragon Database Migration Tool</h1>";

try {
    echo "<p>Starting migrations...</p>";
    Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "<p style='color:green; font-weight:bold;'>✅ All missing tables have been created successfully!</p>";
} catch (\Exception $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ Error running migrations: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/dashboard'>Return to Dashboard</a></p>";

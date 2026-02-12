<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
// Kernel handling boots the app

echo "<div style='font-family:monospace; padding:20px; background:#f5f5f5;'>";
echo "<h1>Debug Info</h1>";
echo "<p><strong>App URL:</strong> " . config('app.url') . "</p>";
echo "<p><strong>Livewire Config Asset URL:</strong> " . config('livewire.asset_url') . "</p>";
echo "<p><strong>Calculated Asset Path:</strong> " . asset('vendor/livewire/livewire.js') . "</p>";
echo "<p><strong>Current Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

$path = __DIR__ . '/vendor/livewire/livewire.js';
echo "<p><strong>File System Check:</strong> " . $path . "</p>";
echo "<p><strong>File Exists:</strong> " . (file_exists($path) ? '<span style="color:green">YES</span>' : '<span style="color:red">NO</span>') . "</p>";
echo "</div>";

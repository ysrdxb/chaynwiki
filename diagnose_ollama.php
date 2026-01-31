<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$ollama = app('App\Services\OllamaService');

echo "--- Ollama Diagnostics ---\n";
echo "URL: " . config('services.ollama.url') . "\n";
echo "Model: " . config('services.ollama.model') . "\n";
echo "Demo Mode: " . (config('services.ollama.demo_mode') ? 'ACTIVE' : 'INACTIVE') . "\n";
echo "Is Available: " . ($ollama->isAvailable() ? 'YES' : 'NO') . "\n";

try {
    $response = Illuminate\Support\Facades\Http::timeout(5)->get(config('services.ollama.url') . '/api/tags');
    if ($response->successful()) {
        echo "Direct Connectivity: SUCCESS\n";
        echo "Models Found: " . count($response->json('models', [])) . "\n";
        foreach ($response->json('models', []) as $m) {
            echo "  - " . $m['name'] . "\n";
        }
    } else {
        echo "Direct Connectivity: FAILED (" . $response->status() . ")\n";
    }
} catch (\Exception $e) {
    echo "Direct Connectivity: ERROR (" . $e->getMessage() . ")\n";
}

echo "--------------------------\n";

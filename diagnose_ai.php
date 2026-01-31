<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "--- Unified AI Diagnostics ---\n";
$driver = config('services.ai.driver');
echo "Current Driver: " . strtoupper($driver) . "\n";

$ai = app('App\Services\AIService');
echo "Is Available: " . ($ai->isAvailable() ? 'YES' : 'NO') . "\n";

if ($driver === 'groq') {
    $key = config('services.groq.key');
    echo "Groq API Key: " . ($key ? 'SET (Ends in ...' . substr($key, -4) . ')' : 'MISSING') . "\n";
    echo "Groq Model: " . config('services.groq.model') . "\n";
}

echo "\nTesting Generation (Prompt: 'Say hello in one word')...\n";
$start = microtime(true);
$response = $ai->generate("Say hello in one word");
$end = microtime(true);

echo "Response: " . trim($response ?? 'NULL') . "\n";
echo "Time Taken: " . round($end - $start, 2) . "s\n";

echo "------------------------------\n";

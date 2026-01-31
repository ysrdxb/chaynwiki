<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$ai = app('App\Services\AIService');
$key = config('services.groq.key');
$url = config('services.groq.url');
$model = config('services.groq.model');

echo "Testing Groq Direct Call...\n";
echo "URL: $url\n";
echo "Model: $model\n";
echo "Key Prefix: " . substr($key, 0, 10) . "...\n";

try {
    $response = Illuminate\Support\Facades\Http::withToken($key)
        ->timeout(10)
        ->post("$url/chat/completions", [
            'model' => $model,
            'messages' => [['role' => 'user', 'content' => 'Say hi']],
            'stream' => false,
        ]);

    echo "Status: " . $response->status() . "\n";
    if ($response->successful()) {
        echo "Body: " . $response->json('choices.0.message.content') . "\n";
    } else {
        echo "Error Body: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

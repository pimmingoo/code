<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking factory method...\n";
    $factory = App\Models\Employer::factory();
    echo "Factory exists: " . get_class($factory) . "\n";
    $employer = $factory->create();
    echo "Employer created: " . $employer->name . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
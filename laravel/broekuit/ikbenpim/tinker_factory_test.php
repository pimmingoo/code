<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    App\Models\Job::factory(1)->create();
    echo "ok\n";
} catch (Throwable $e) {
    echo get_class($e) . "\n" . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

<?php
// Temporary script to fix migrations table
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Delete the failed migration record
DB::table('migrations')->where('migration', '2026_05_12_000004_create_e_resources_table')->delete();

echo "Migration record deleted. Now run: php artisan migrate --force\n";

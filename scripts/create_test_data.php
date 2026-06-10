<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Archive log
$log = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($log)) {
  $ts = date('YmdHis');
  rename($log, __DIR__ . "/../storage/logs/laravel.log.$ts");
}
file_put_contents($log, "");
echo "Archived existing log and created fresh laravel.log\n";

// Create test user
use App\Models\User;
use App\Models\Article;

$email = 'dev+test@example.com';
$user = User::where('email', $email)->first();
if (!$user) {
  $user = User::create([
    'name' => 'Dev Tester',
    'email' => $email,
    'password' => bcrypt('Password123!'),
    'role' => 'super-admin',
  ]);
  echo "Created user: {$email}\n";
} else {
  echo "User already exists: {$email}\n";
}

// Create test article
$article = Article::create([
  'title' => 'Automated Test Article',
  'content' => 'This is a test article created by automated check.',
  'excerpt' => 'Test excerpt',
  'is_published' => true,
  'author_id' => $user->id,
]);

if ($article) {
  echo "Created article id: {$article->id}\n";
} else {
  echo "Failed to create article\n";
}

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Article;

$result = ['user' => null, 'article' => null, 'errors' => []];

try {
  $user = User::where('email', 'dev+test@example.com')->first();
  if ($user) {
    $result['user'] = $user->toArray();
  }
} catch (\Throwable $e) {
  $result['errors'][] = 'user_error: ' . $e->getMessage();
}

try {
  $article = Article::where('title', 'Automated Test Article')->first();
  if ($article) {
    $result['article'] = $article->toArray();
  }
} catch (\Throwable $e) {
  $result['errors'][] = 'article_error: ' . $e->getMessage();
}

file_put_contents(__DIR__ . '/../storage/test_verification.json', json_encode($result, JSON_PRETTY_PRINT));
echo "WROTE: storage/test_verification.json\n";

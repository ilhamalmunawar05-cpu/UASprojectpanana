<?php
$urls = [
  'http://127.0.0.1:8000/',
  'http://127.0.0.1:8000/login',
  'http://127.0.0.1:8000/register',
  'http://127.0.0.1:8000/admin/dashboard',
  'http://127.0.0.1:8000/user/dashboard',
  'http://127.0.0.1:8000/articles',
  'http://127.0.0.1:8000/admin/articles',
];
foreach ($urls as $u) {
  $ctx = stream_context_create(['http' => ['timeout' => 5]]);
  $start = microtime(true);
  $content = @file_get_contents($u, false, $ctx);
  $time = round(microtime(true) - $start, 3);
  if ($content === false) {
    $err = error_get_last();
    $msg = $err && isset($err['message']) ? $err['message'] : 'request failed';
    echo "URL: $u | ERROR: $msg" . PHP_EOL;
  } else {
    echo "URL: $u | OK | Length: " . strlen($content) . " | Time: {$time}s" . PHP_EOL;
  }
}

echo '--- LAST 200 LOG LINES ---' . PHP_EOL;
$log = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($log)) {
  $lines = file($log, FILE_IGNORE_NEW_LINES);
  $total = count($lines);
  $start = $total > 200 ? $total - 200 : 0;
  for ($i = $start; $i < $total; $i++) {
    echo $lines[$i] . PHP_EOL;
  }
} else {
  echo "No laravel.log found" . PHP_EOL;
}

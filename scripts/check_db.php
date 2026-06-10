<?php
// Standalone DB checker to avoid bootstrapping Laravel (avoids provider/view errors)
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
  echo json_encode(['error' => '.env not found at ' . $envPath]);
  exit(1);
}
$env = file_get_contents($envPath);
$lines = preg_split('/\r?\n/', $env);
$config = [];
foreach ($lines as $line) {
  if (strpos(trim($line), '#') === 0) continue;
  if (preg_match('/^([A-Z_]+)=(.*)$/', $line, $m)) {
    $key = $m[1];
    $val = $m[2];
    // strip surrounding quotes
    if ((substr($val, 0, 1) === '"' && substr($val, -1) === '"') || (substr($val, 0, 1) === "'" && substr($val, -1) === "'")) {
      $val = substr($val, 1, -1);
    }
    $config[$key] = $val;
  }
}
$db = [
  'host' => $config['DB_HOST'] ?? '127.0.0.1',
  'port' => $config['DB_PORT'] ?? '3306',
  'database' => $config['DB_DATABASE'] ?? '',
  'user' => $config['DB_USERNAME'] ?? '',
  'pass' => $config['DB_PASSWORD'] ?? '',
];
$dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset=utf8mb4";
try {
  $pdo = new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
  echo json_encode(['error' => 'DB connection failed: ' . $e->getMessage()]);
  exit(2);
}
$out = ['user' => null, 'article' => null];
try {
  $stmt = $pdo->prepare('SELECT id,email,name,role FROM users WHERE email = ? LIMIT 1');
  $stmt->execute(['dev+test@example.com']);
  $out['user'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
} catch (Exception $e) {
  $out['user_error'] = $e->getMessage();
}
try {
  $stmt = $pdo->prepare('SELECT id,title,is_published,author_id,created_at FROM articles WHERE title = ? LIMIT 1');
  $stmt->execute(['Automated Test Article']);
  $out['article'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
} catch (Exception $e) {
  $out['article_error'] = $e->getMessage();
}
echo json_encode($out, JSON_PRETTY_PRINT);

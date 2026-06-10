<?php
/**
 * Script untuk membuat GitHub Issues secara otomatis
 * Pastikan Anda sudah set GitHub token di environment variable
 * 
 * Cara menggunakan:
 * 1. Set GITHUB_TOKEN di environment: export GITHUB_TOKEN=your_token_here
 * 2. Jalankan: php scripts/create_issues.php
 */

// Konfigurasi
$owner = 'ilhamalmunawar05-cpu';
$repo = 'UASprojectpanana';
$githubToken = getenv('GITHUB_TOKEN');

if (!$githubToken) {
    echo "❌ ERROR: GITHUB_TOKEN tidak ditemukan!\n";
    echo "Cara set token:\n";
    echo "  export GITHUB_TOKEN=ghp_xxxxxxxxxxxxxxxxxxxx\n\n";
    exit(1);
}

// Daftar issues yang akan dibuat
$issues = [
    [
        'title' => 'Fitur Login & Registrasi',
        'body' => '## Deskripsi\nImplementasi sistem login dan registrasi pengguna dengan validasi email dan password yang kuat.\n\n## Acceptance Criteria\n- [ ] Form login responsif\n- [ ] Form registrasi dengan validasi\n- [ ] Email verification\n- [ ] Password recovery',
        'labels' => ['feature', 'authentication'],
    ],
    [
        'title' => 'Dashboard Admin - Manajemen Buku',
        'body' => '## Deskripsi\nBuat dashboard untuk admin mengelola koleksi buku (CRUD).\n\n## Acceptance Criteria\n- [ ] List buku dengan pagination\n- [ ] Form tambah/edit buku\n- [ ] Upload cover buku\n- [ ] Filter berdasarkan kategori\n- [ ] Soft delete support',
        'labels' => ['feature', 'admin'],
    ],
    [
        'title' => 'Sistem Peminjaman & Pengembalian Buku',
        'body' => '## Deskripsi\nImplementasi workflow peminjaman dan pengembalian buku dengan tracking denda otomatis.\n\n## Acceptance Criteria\n- [ ] Proses peminjaman user-friendly\n- [ ] Auto-calculate denda ketika terlambat\n- [ ] Tracking status pengembalian\n- [ ] Email notification',
        'labels' => ['feature', 'loans'],
    ],
    [
        'title' => 'Bug Fix - Database Connection Timeout',
        'body' => '## Deskripsi\nDatabase connection sering timeout saat traffic tinggi.\n\n## Steps to Reproduce\n1. Jalankan load test dengan 50+ concurrent users\n2. Observe connection pool exhaustion\n\n## Expected Behavior\nConnection pool seharusnya handle gracefully\n\n## Actual Behavior\nError 500 Internal Server Error',
        'labels' => ['bug', 'database'],
    ],
    [
        'title' => 'Dokumentasi API Endpoints',
        'body' => '## Deskripsi\nLengkapi dokumentasi untuk semua REST API endpoints dengan Swagger/OpenAPI.\n\n## Acceptance Criteria\n- [ ] API documentation complete\n- [ ] Add OpenAPI spec\n- [ ] Example requests & responses\n- [ ] Authentication guide',
        'labels' => ['documentation', 'api'],
    ],
];

// Function untuk membuat issue via GitHub API
function createGitHubIssue($owner, $repo, $title, $body, $labels, $token) {
    $url = "https://api.github.com/repos/$owner/$repo/issues";
    
    $data = [
        'title' => $title,
        'body' => $body,
        'labels' => $labels,
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'Accept: application/vnd.github.v3+json',
        'User-Agent: UASprojectpanana',
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'error' => $error,
        ];
    }
    
    $result = json_decode($response, true);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        return [
            'success' => true,
            'issue_number' => $result['number'] ?? null,
            'issue_url' => $result['html_url'] ?? null,
        ];
    } else {
        return [
            'success' => false,
            'error' => $result['message'] ?? 'Unknown error',
            'http_code' => $httpCode,
        ];
    }
}

// Main execution
echo "🚀 Memulai pembuatan GitHub Issues...\n";
echo "📦 Repository: $owner/$repo\n";
echo str_repeat("=", 60) . "\n\n";

$successCount = 0;
$failCount = 0;

foreach ($issues as $index => $issue) {
    echo "[" . ($index + 1) . "/" . count($issues) . "] Membuat issue: {$issue['title']}\n";
    
    $result = createGitHubIssue(
        $owner,
        $repo,
        $issue['title'],
        $issue['body'],
        $issue['labels'],
        $githubToken
    );
    
    if ($result['success']) {
        echo "  ✅ Berhasil! Issue #{$result['issue_number']}\n";
        echo "  URL: {$result['issue_url']}\n\n";
        $successCount++;
    } else {
        echo "  ❌ Gagal: {$result['error']}\n\n";
        $failCount++;
    }
    
    // Delay untuk menghindari rate limiting (100ms)
    usleep(100000);
}

echo str_repeat("=", 60) . "\n";
echo "📊 Ringkasan:\n";
echo "  ✅ Berhasil: $successCount\n";
echo "  ❌ Gagal: $failCount\n";
echo "  📝 Total: " . count($issues) . "\n\n";

if ($successCount === count($issues)) {
    echo "🎉 Semua issues berhasil dibuat!\n";
} else if ($successCount > 0) {
    echo "⚠️  Beberapa issues gagal dibuat.\n";
} else {
    echo "❌ Semua issues gagal dibuat.\n";
}
?>

<?php
/**
 * Script untuk membuat GitHub Issues secara otomatis
 * Pastikan Anda sudah set GitHub token di environment variable
 * 
 * Cara menggunakan:
 * 1. Buat Personal Access Token di https://github.com/settings/tokens
 * 2. Set token dengan: $set GITHUB_TOKEN=ghp_xxxxx (Windows)
 * 3. Jalankan: php scripts/create_issues.php
 */

// Konfigurasi
$owner = 'ilhamalmunawar05-cpu';
$repo = 'UASprojectpanana';
$githubToken = getenv('GITHUB_TOKEN');

// Cek di .env.local jika environment variable tidak tersedia
if (!$githubToken && file_exists(__DIR__ . '/../.env.local')) {
    $env = parse_ini_file(__DIR__ . '/../.env.local');
    $githubToken = $env['GITHUB_TOKEN'] ?? null;
}

if (!$githubToken) {
    echo "❌ ERROR: GITHUB_TOKEN tidak ditemukan!\n";
    echo "\n📋 CARA MENGATASI:\n";
    echo "1. Buka: https://github.com/settings/tokens\n";
    echo "2. Click 'Generate new token (classic)'\n";
    echo "3. Pilih scope: 'repo' (full control of private repositories)\n";
    echo "4. Copy token yang dihasilkan\n";
    echo "5. Set token dengan command:\n";
    echo "   Windows (cmd):      set GITHUB_TOKEN=ghp_xxxxxxxxxxxxx\n";
    echo "   Windows (PowerShell): \$env:GITHUB_TOKEN=\"ghp_xxxxxxxxxxxxx\"\n";
    echo "   Linux/Mac:          export GITHUB_TOKEN=ghp_xxxxxxxxxxxxx\n";
    echo "\n6. Jalankan ulang: php scripts/create_issues.php\n\n";
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
// GitHub PAT fine-grained tidak bisa create issues, gunakan Classic PAT
function createGitHubIssue($owner, $repo, $title, $body, $labels, $token) {
    $url = "https://api.github.com/repos/$owner/$repo/issues";
    
    $data = [
        'title' => $title,
        'body' => $body,
    ];
    
    // Jangan tambah labels karena PAT fine-grained tidak support
    // Labels akan ditambah secara terpisah setelah issue dibuat
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'Accept: application/vnd.github.v3+json',
        'User-Agent: UASprojectpanana',
        'Content-Type: application/json',
        'X-GitHub-Api-Version: 2022-11-28',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'error' => "CURL Error: $error",
            'http_code' => null,
        ];
    }
    
    $result = json_decode($response, true);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $issueNumber = $result['number'] ?? null;
        
        // Coba tambah labels secara terpisah
        $labelAdded = true;
        if (!empty($labels)) {
            $labelAdded = addIssueLables($owner, $repo, $issueNumber, $labels, $token);
        }
        
        return [
            'success' => true,
            'issue_number' => $issueNumber,
            'issue_url' => $result['html_url'] ?? null,
            'labels_added' => $labelAdded,
        ];
    } else {
        $errorMsg = $result['message'] ?? 'Unknown error';
        if (isset($result['errors'])) {
            $errorMsg .= ' | ' . json_encode($result['errors']);
        }
        return [
            'success' => false,
            'error' => $errorMsg,
            'http_code' => $httpCode,
        ];
    }
}

// Fungsi tambahan untuk add labels ke issue
function addIssueLables($owner, $repo, $issueNumber, $labels, $token) {
    $url = "https://api.github.com/repos/$owner/$repo/issues/$issueNumber/labels";
    
    $data = $labels;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'Accept: application/vnd.github.v3+json',
        'User-Agent: UASprojectpanana',
        'Content-Type: application/json',
        'X-GitHub-Api-Version: 2022-11-28',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($httpCode >= 200 && $httpCode < 300);
}

// Main execution
echo "🚀 Memulai pembuatan GitHub Issues...\n";
echo "📦 Repository: $owner/$repo\n";
echo "🔐 Token: " . substr($githubToken, 0, 10) . "..." . substr($githubToken, -10) . "\n";
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
        $labelStatus = isset($result['labels_added']) && !$result['labels_added'] ? ' (labels gagal ditambah)' : '';
        echo "  ✅ Berhasil! Issue #{$result['issue_number']}{$labelStatus}\n";
        echo "  URL: {$result['issue_url']}\n\n";
        $successCount++;
    } else {
        echo "  ❌ Gagal: {$result['error']}";
        if (isset($result['http_code'])) {
            echo " (HTTP {$result['http_code']})";
        }
        echo "\n\n";
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
    echo "💡 Terkadang label belum ada. Jalankan script setup dulu jika diperlukan.\n";
} else {
    echo "❌ Semua issues gagal dibuat.\n";
    echo "💡 Periksa:\n";
    echo "   1. GITHUB_TOKEN valid dan punya permission 'repo'\n";
    echo "   2. Repository benar: $owner/$repo\n";
    echo "   3. Koneksi internet stabil\n";
}
?>

#!/usr/bin/env php
<?php

/**
 * Database Scripts Quick Reference
 * Shows available commands and their usage
 * Usage: php database/help.php
 */

echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║     SEKAWAN Lab Database Scripts - Quick Reference       ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$commands = [
    [
        'script' => 'setup.php',
        'description' => 'Full setup (migration + seeder)',
        'usage' => 'php database/setup.php',
        'use_case' => 'First time setup atau fresh install',
        'emoji' => '🚀'
    ],
    [
        'script' => 'migrate.php',
        'description' => 'Create database structure only',
        'usage' => 'php database/migrate.php',
        'use_case' => 'Update struktur tabel tanpa data',
        'emoji' => '🔧'
    ],
    [
        'script' => 'seed.php',
        'description' => 'Insert sample data only',
        'usage' => 'php database/seed.php',
        'use_case' => 'Mengisi data sample untuk testing',
        'emoji' => '🌱'
    ],
    [
        'script' => 'reset.php',
        'description' => 'Drop all tables',
        'usage' => 'php database/reset.php',
        'use_case' => 'Hapus semua tabel (clean slate)',
        'emoji' => '🗑️'
    ],
    [
        'script' => 'status.php',
        'description' => 'Show database status & statistics',
        'usage' => 'php database/status.php',
        'use_case' => 'Cek kondisi database saat ini',
        'emoji' => '📊'
    ],
    [
        'script' => 'help.php',
        'description' => 'Show this help message',
        'usage' => 'php database/help.php',
        'use_case' => 'Lihat daftar command yang tersedia',
        'emoji' => '❓'
    ]
];

foreach ($commands as $index => $cmd) {
    echo "{$cmd['emoji']}  {$cmd['script']}\n";
    echo "   Description : {$cmd['description']}\n";
    echo "   Usage       : {$cmd['usage']}\n";
    echo "   Use Case    : {$cmd['use_case']}\n";
    
    if ($index < count($commands) - 1) {
        echo "\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "📝 COMMON WORKFLOWS:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "1️⃣  First Time Setup:\n";
echo "   php database/setup.php\n\n";

echo "2️⃣  Fresh Install (Reset + Setup):\n";
echo "   php database/reset.php\n";
echo "   php database/setup.php\n\n";

echo "3️⃣  Update Structure Only:\n";
echo "   php database/reset.php\n";
echo "   php database/migrate.php\n\n";

echo "4️⃣  Check Database Status:\n";
echo "   php database/status.php\n\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "🔐 DEFAULT LOGIN CREDENTIALS:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$credentials = [
    ['Role' => 'Admin', 'Username' => 'ADMIN001', 'Email' => 'admin@sekawanlab.com'],
    ['Role' => 'Dosen', 'Username' => 'DOSEN001', 'Email' => 'budi.santoso@polinema.ac.id'],
    ['Role' => 'Talent', 'Username' => '2341760001', 'Email' => 'ahmad.rizki@student.polinema.ac.id'],
];

foreach ($credentials as $cred) {
    printf("%-8s | %-12s | %s\n", $cred['Role'], $cred['Username'], $cred['Email']);
}

echo "\nPassword: (menggunakan hash yang sama untuk semua account)\n";
echo "Hash: \$2y\$12\$pfn0anta0yqNf06SFEtoKOOkddS13FxV4OpogGwNmxcWo7/Ln0snC\n\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "📦 TABLES CREATED:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$tables = [
    'personil' => 'Personil dengan authentication (admin, dosen, talent)',
    'project' => 'Project yang dikerjakan personil',
    'kategori' => 'Kategori untuk blog post',
    'blog_post' => 'Artikel/blog dengan featured image',
    'profil_page' => 'Halaman profil laboratorium (about, visi-misi, dll)',
    'join_application' => 'Aplikasi pendaftaran anggota baru',
    'personil_invitation' => 'Invitation token untuk personil'
];

foreach ($tables as $table => $description) {
    printf("%-25s: %s\n", $table, $description);
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "💡 TIPS:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "• Semua script menggunakan transaction untuk keamanan\n";
echo "• Jika ada error, perubahan akan di-rollback otomatis\n";
echo "• Pastikan PostgreSQL service running sebelum menjalankan\n";
echo "• Update config/database.php sesuai environment Anda\n";
echo "• Untuk production, ubah password default!\n\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "📚 DOCUMENTATION:\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "Baca database/README.md untuk dokumentasi lengkap\n\n";

echo "✅ Ready to start? Run: php database/setup.php\n";

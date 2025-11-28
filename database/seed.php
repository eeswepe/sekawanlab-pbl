#!/usr/bin/env php
<?php

/**
 * Database Seeder Script
 * Run: php database/seed.php
 */

// Load database config
$config = require_once __DIR__ . '/../config/database.php';

try {
    // Connect to PostgreSQL
    $dsn = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s",
        $config['host'],
        $config['port'],
        $config['database']
    );
    
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "🔗 Connected to database: {$config['database']}\n";
    echo "🌱 Starting seeding process...\n\n";
    
    // Default password (hashed)
    $defaultPassword = '$2y$12$pfn0anta0yqNf06SFEtoKOOkddS13FxV4OpogGwNmxcWo7/Ln0snC';
    
    // Start transaction
    $pdo->beginTransaction();
    
    // ============================================
    // 1. SEED PERSONIL
    // ============================================
    echo "👥 Seeding personil...\n";
    
    $personilData = [
        [
            'nim_nip' => 'ADMIN001',
            'password' => $defaultPassword,
            'nama_lengkap' => 'Admin Sekawan Lab',
            'role' => 'admin',
            'spesialisasi' => 'System Administration',
            'email' => 'admin@sekawanlab.com',
            'phone' => '081234567890',
            'location' => 'Malang, Indonesia',
            'tanggal_bergabung' => '2024-01-01',
            'bio' => 'Administrator sistem SEKAWAN Lab dengan pengalaman dalam manajemen laboratorium dan pengembangan sistem.',
            'skills' => json_encode(['System Administration', 'Database Management', 'Project Management']),
            'foto_url' => null
        ],
        [
            'nim_nip' => 'DOSEN001',
            'password' => $defaultPassword,
            'nama_lengkap' => 'Dr. Budi Santoso, S.Kom., M.T.',
            'role' => 'dosen',
            'spesialisasi' => 'Software Engineering',
            'email' => 'budi.santoso@polinema.ac.id',
            'phone' => '081234567891',
            'location' => 'Malang, Indonesia',
            'tanggal_bergabung' => '2024-01-15',
            'bio' => 'Dosen pembimbing SEKAWAN Lab dengan fokus pada Software Engineering dan pengembangan aplikasi enterprise.',
            'skills' => json_encode(['Software Engineering', 'Database Design', 'Web Development', 'Mobile Development']),
            'foto_url' => null
        ],
        [
            'nim_nip' => '2341760001',
            'password' => $defaultPassword,
            'nama_lengkap' => 'Ahmad Rizki Pratama',
            'role' => 'talent',
            'spesialisasi' => 'Full Stack Developer',
            'email' => 'ahmad.rizki@student.polinema.ac.id',
            'phone' => '081234567892',
            'location' => 'Malang, Indonesia',
            'tanggal_bergabung' => '2024-02-01',
            'bio' => 'Mahasiswa Teknik Informatika yang passionate dalam web development dan open source contribution.',
            'skills' => json_encode(['PHP', 'JavaScript', 'PostgreSQL', 'React', 'Node.js']),
            'foto_url' => null
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO personil (nim_nip, password, nama_lengkap, role, spesialisasi, email, phone, location, tanggal_bergabung, bio, skills, foto_url)
        VALUES (:nim_nip, :password, :nama_lengkap, :role, :spesialisasi, :email, :phone, :location, :tanggal_bergabung, :bio, :skills, :foto_url)
        RETURNING id
    ");
    
    $personilIds = [];
    foreach ($personilData as $personil) {
        $stmt->execute($personil);
        $result = $stmt->fetch();
        $personilIds[$personil['role']] = $result['id'];
        echo "   ✓ Created {$personil['role']}: {$personil['nama_lengkap']}\n";
    }
    
    echo "   📊 Total personil seeded: " . count($personilData) . "\n\n";
    
    // ============================================
    // 2. SEED KATEGORI
    // ============================================
    echo "📁 Seeding kategori...\n";
    
    $kategoriData = [
        ['name' => 'Tutorial', 'post_count' => 0],
        ['name' => 'Project Showcase', 'post_count' => 0],
        ['name' => 'Research', 'post_count' => 0],
        ['name' => 'News & Updates', 'post_count' => 0],
        ['name' => 'Technology', 'post_count' => 0],
        ['name' => 'Best Practices', 'post_count' => 0],
        ['name' => 'Case Study', 'post_count' => 0],
        ['name' => 'Event', 'post_count' => 0]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO kategori (name, post_count)
        VALUES (:name, :post_count)
        RETURNING id
    ");
    
    $kategoriIds = [];
    foreach ($kategoriData as $kategori) {
        $stmt->execute($kategori);
        $result = $stmt->fetch();
        $kategoriIds[$kategori['name']] = $result['id'];
        echo "   ✓ Created kategori: {$kategori['name']}\n";
    }
    
    echo "   📊 Total kategori seeded: " . count($kategoriData) . "\n\n";
    
    // ============================================
    // 3. SEED PROJECT
    // ============================================
    echo "🚀 Seeding project...\n";
    
    $projectData = [
        [
            'personil_id' => $personilIds['talent'],
            'title' => 'SEKAWAN Lab Management System',
            'description' => 'Sistem manajemen laboratorium yang komprehensif dengan fitur blog, rekrutmen, dan manajemen personil. Dibangun menggunakan PHP MVC dan PostgreSQL.',
        ],
        [
            'personil_id' => $personilIds['talent'],
            'title' => 'E-Learning Platform',
            'description' => 'Platform pembelajaran online dengan fitur video streaming, quiz interaktif, dan tracking progress mahasiswa.',
        ],
        [
            'personil_id' => $personilIds['dosen'],
            'title' => 'Research Data Analytics Tool',
            'description' => 'Tool untuk analisis data penelitian dengan visualisasi interaktif dan export ke berbagai format.',
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO project (personil_id, title, description)
        VALUES (:personil_id, :title, :description)
    ");
    
    foreach ($projectData as $project) {
        $stmt->execute($project);
        echo "   ✓ Created project: {$project['title']}\n";
    }
    
    echo "   📊 Total project seeded: " . count($projectData) . "\n\n";
    
    // ============================================
    // 4. SEED BLOG_POST
    // ============================================
    echo "📝 Seeding blog_post...\n";
    
    $blogPostData = [
        [
            'penulis_id' => $personilIds['talent'],
            'kategori_id' => $kategoriIds['Tutorial'],
            'slug' => 'getting-started-with-php-mvc',
            'judul' => 'Getting Started with PHP MVC Architecture',
            'cuplikan' => 'Panduan lengkap memulai development dengan arsitektur MVC menggunakan PHP murni tanpa framework.',
            'konten' => '<p>Model-View-Controller (MVC) adalah pola arsitektur yang memisahkan aplikasi menjadi tiga komponen utama: Model, View, dan Controller.</p><p>Dalam artikel ini, kita akan membahas cara implementasi MVC dari nol menggunakan PHP.</p><h2>Apa itu MVC?</h2><p>MVC membagi aplikasi menjadi tiga layer yang berbeda, masing-masing dengan tanggung jawab spesifik...</p>',
            'penulis_nama' => 'Ahmad Rizki Pratama',
            'penulis_bio' => 'Full Stack Developer di SEKAWAN Lab',
            'tanggal_publish' => date('Y-m-d H:i:s'),
            'featured_image_url' => null,
            'status' => 'published',
            'reading_time' => 8
        ],
        [
            'penulis_id' => $personilIds['dosen'],
            'kategori_id' => $kategoriIds['Research'],
            'slug' => 'best-practices-database-design',
            'judul' => 'Best Practices in Database Design',
            'cuplikan' => 'Prinsip-prinsip penting dalam mendesain database yang efisien dan scalable.',
            'konten' => '<p>Database design adalah fondasi dari setiap aplikasi yang sukses. Design yang baik akan mempengaruhi performance, maintainability, dan scalability aplikasi.</p><h2>Normalisasi Database</h2><p>Normalisasi adalah proses organizing data untuk mengurangi redundansi...</p>',
            'penulis_nama' => 'Dr. Budi Santoso, S.Kom., M.T.',
            'penulis_bio' => 'Dosen Software Engineering di Politeknik Negeri Malang',
            'tanggal_publish' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'featured_image_url' => null,
            'status' => 'published',
            'reading_time' => 12
        ],
        [
            'penulis_id' => $personilIds['talent'],
            'kategori_id' => $kategoriIds['Project Showcase'],
            'slug' => 'building-sekawan-lab-platform',
            'judul' => 'Building SEKAWAN Lab Platform: A Case Study',
            'cuplikan' => 'Pengalaman dan pembelajaran dalam membangun platform manajemen laboratorium dari nol.',
            'konten' => '<p>SEKAWAN Lab adalah platform yang dikembangkan untuk mengelola aktivitas laboratorium Software Engineering.</p><h2>Tech Stack</h2><ul><li>PHP dengan arsitektur MVC</li><li>PostgreSQL untuk database</li><li>Bootstrap & AdminLTE untuk UI</li></ul><p>Dalam project ini, kami menghadapi berbagai challenges...</p>',
            'penulis_nama' => 'Ahmad Rizki Pratama',
            'penulis_bio' => 'Full Stack Developer di SEKAWAN Lab',
            'tanggal_publish' => date('Y-m-d H:i:s', strtotime('-3 days')),
            'featured_image_url' => null,
            'status' => 'published',
            'reading_time' => 15
        ],
        [
            'penulis_id' => $personilIds['admin'],
            'kategori_id' => $kategoriIds['News & Updates'],
            'slug' => 'sekawan-lab-recruitment-2024',
            'judul' => 'SEKAWAN Lab Open Recruitment 2024',
            'cuplikan' => 'Kami membuka kesempatan bagi mahasiswa untuk bergabung dengan SEKAWAN Lab.',
            'konten' => '<p>SEKAWAN Lab dengan bangga mengumumkan open recruitment untuk periode 2024.</p><h2>Posisi yang Tersedia</h2><ul><li>Web Developer</li><li>Mobile Developer</li><li>UI/UX Designer</li><li>Database Administrator</li></ul><p>Daftarkan diri Anda sekarang!</p>',
            'penulis_nama' => 'Admin Sekawan Lab',
            'penulis_bio' => 'Administrator SEKAWAN Lab',
            'tanggal_publish' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'featured_image_url' => null,
            'status' => 'published',
            'reading_time' => 5
        ],
        [
            'penulis_id' => $personilIds['dosen'],
            'kategori_id' => $kategoriIds['Technology'],
            'slug' => 'introduction-to-postgresql',
            'judul' => 'Introduction to PostgreSQL for Beginners',
            'cuplikan' => 'Memahami dasar-dasar PostgreSQL dan mengapa database ini menjadi pilihan populer.',
            'konten' => '<p>PostgreSQL adalah sistem manajemen database relasional yang powerful dan open source.</p><h2>Keunggulan PostgreSQL</h2><ul><li>ACID Compliant</li><li>Support untuk JSON</li><li>Advanced indexing</li><li>Full-text search</li></ul>',
            'penulis_nama' => 'Dr. Budi Santoso, S.Kom., M.T.',
            'penulis_bio' => 'Dosen Software Engineering di Politeknik Negeri Malang',
            'tanggal_publish' => date('Y-m-d H:i:s', strtotime('-2 weeks')),
            'featured_image_url' => null,
            'status' => 'published',
            'reading_time' => 10
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO blog_post (penulis_id, kategori_id, slug, judul, cuplikan, konten, penulis_nama, penulis_bio, tanggal_publish, featured_image_url, status, reading_time)
        VALUES (:penulis_id, :kategori_id, :slug, :judul, :cuplikan, :konten, :penulis_nama, :penulis_bio, :tanggal_publish, :featured_image_url, :status, :reading_time)
    ");
    
    foreach ($blogPostData as $blog) {
        $stmt->execute($blog);
        echo "   ✓ Created blog post: {$blog['judul']}\n";
    }
    
    echo "   📊 Total blog posts seeded: " . count($blogPostData) . "\n\n";
    
    // Update post_count di kategori
    $pdo->exec("
        UPDATE kategori 
        SET post_count = (
            SELECT COUNT(*) 
            FROM blog_post 
            WHERE blog_post.kategori_id = kategori.id 
            AND blog_post.status = 'published'
        )
    ");
    
    // ============================================
    // 5. SEED PROFIL_PAGE
    // ============================================
    echo "📄 Seeding profil_page...\n";
    
    $profilPageData = [
        [
            'slug' => 'tentang-kami',
            'page_title' => 'Tentang SEKAWAN Lab',
            'page_subtitle' => 'Mengenal lebih dekat laboratorium Software Engineering',
            'featured_image_url' => null,
            'content_title' => 'Sejarah dan Visi SEKAWAN Lab',
            'content_subtitle' => 'Membangun ekosistem pengembangan software yang inovatif'
        ],
        [
            'slug' => 'visi-misi',
            'page_title' => 'Visi & Misi',
            'page_subtitle' => 'Komitmen kami dalam pendidikan dan penelitian',
            'featured_image_url' => null,
            'content_title' => 'Visi dan Misi Laboratorium',
            'content_subtitle' => 'Mencetak software engineer berkualitas tinggi'
        ],
        [
            'slug' => 'fasilitas',
            'page_title' => 'Fasilitas Laboratorium',
            'page_subtitle' => 'Infrastruktur dan peralatan yang mendukung pembelajaran',
            'featured_image_url' => null,
            'content_title' => 'Fasilitas yang Tersedia',
            'content_subtitle' => 'Perangkat modern untuk pengembangan software'
        ],
        [
            'slug' => 'program-kerja',
            'page_title' => 'Program Kerja',
            'page_subtitle' => 'Kegiatan dan program yang kami jalankan',
            'featured_image_url' => null,
            'content_title' => 'Program Kerja Tahunan',
            'content_subtitle' => 'Workshop, seminar, dan kegiatan pengembangan skill'
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO profil_page (slug, page_title, page_subtitle, featured_image_url, content_title, content_subtitle)
        VALUES (:slug, :page_title, :page_subtitle, :featured_image_url, :content_title, :content_subtitle)
    ");
    
    foreach ($profilPageData as $page) {
        $stmt->execute($page);
        echo "   ✓ Created profil page: {$page['page_title']}\n";
    }
    
    echo "   📊 Total profil pages seeded: " . count($profilPageData) . "\n\n";
    
    // ============================================
    // 6. SEED JOIN_APPLICATION
    // ============================================
    echo "📋 Seeding join_application...\n";
    
    $joinApplicationData = [
        [
            'nama_lengkap' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@student.polinema.ac.id',
            'phone' => '081234567893',
            'nim' => '2341760050',
            'prodi' => 'TI',
            'semester' => 5,
            'alasan_bergabung' => 'Saya sangat tertarik dengan pengembangan web dan ingin belajar lebih dalam tentang software engineering. SEKAWAN Lab adalah tempat yang tepat untuk mengembangkan skill saya.',
            'github_url' => 'https://github.com/sitinurhaliza',
            'cv_file_path' => null,
            'tanggal_apply' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'status' => 'pending',
            'catatan_admin' => null,
            'assessor_summary' => null
        ],
        [
            'nama_lengkap' => 'Andi Wijaya',
            'email' => 'andi.wijaya@student.polinema.ac.id',
            'phone' => '081234567894',
            'nim' => '2341760051',
            'prodi' => 'TI',
            'semester' => 3,
            'alasan_bergabung' => 'Saya ingin berkontribusi dalam project-project nyata dan belajar dari senior yang berpengalaman. Mobile development adalah passion saya.',
            'github_url' => 'https://github.com/andiwijaya',
            'cv_file_path' => null,
            'tanggal_apply' => date('Y-m-d H:i:s', strtotime('-3 days')),
            'status' => 'reviewed',
            'catatan_admin' => 'Kandidat potensial dengan portfolio mobile development yang bagus',
            'assessor_summary' => null
        ],
        [
            'nama_lengkap' => 'Dewi Lestari',
            'email' => 'dewi.lestari@student.polinema.ac.id',
            'phone' => '081234567895',
            'nim' => '2341760052',
            'prodi' => 'TI',
            'semester' => 5,
            'alasan_bergabung' => 'Sebagai mahasiswa yang passionate di UI/UX design, saya ingin berkontribusi dalam membuat interface yang user-friendly untuk project laboratorium.',
            'github_url' => 'https://github.com/dewilestari',
            'cv_file_path' => null,
            'tanggal_apply' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'status' => 'accepted',
            'catatan_admin' => 'Diterima sebagai UI/UX Designer',
            'assessor_summary' => 'Strong portfolio in UI/UX design. Good communication skills.'
        ],
        [
            'nama_lengkap' => 'Rudi Hartono',
            'email' => 'rudi.hartono@student.polinema.ac.id',
            'phone' => '081234567896',
            'nim' => '2341760053',
            'prodi' => 'TI',
            'semester' => 7,
            'alasan_bergabung' => 'Saya ingin mengaplikasikan ilmu database yang saya pelajari dan berkontribusi dalam optimasi sistem database laboratorium.',
            'github_url' => 'https://github.com/rudihartono',
            'cv_file_path' => null,
            'tanggal_apply' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'status' => 'rejected',
            'catatan_admin' => 'Kuota untuk posisi database administrator sudah penuh',
            'assessor_summary' => null
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO join_application (nama_lengkap, email, phone, nim, prodi, semester, alasan_bergabung, github_url, cv_file_path, tanggal_apply, status, catatan_admin, assessor_summary)
        VALUES (:nama_lengkap, :email, :phone, :nim, :prodi, :semester, :alasan_bergabung, :github_url, :cv_file_path, :tanggal_apply, :status, :catatan_admin, :assessor_summary)
    ");
    
    foreach ($joinApplicationData as $application) {
        $stmt->execute($application);
        echo "   ✓ Created application: {$application['nama_lengkap']} ({$application['status']})\n";
    }
    
    echo "   📊 Total applications seeded: " . count($joinApplicationData) . "\n\n";
    
    // ============================================
    // 7. SEED PERSONIL_INVITATION
    // ============================================
    echo "🔑 Seeding personil_invitation...\n";
    
    $invitationData = [
        [
            'personil_id' => $personilIds['talent'],
            'secret_key' => bin2hex(random_bytes(32)),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'is_used' => false
        ],
        [
            'personil_id' => $personilIds['dosen'],
            'secret_key' => bin2hex(random_bytes(32)),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'is_used' => false
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO personil_invitation (personil_id, secret_key, expires_at, is_used)
        VALUES (:personil_id, :secret_key, :expires_at, :is_used)
    ");
    
    foreach ($invitationData as $invitation) {
        $stmt->execute($invitation);
        echo "   ✓ Created invitation for personil_id: {$invitation['personil_id']}\n";
    }
    
    echo "   📊 Total invitations seeded: " . count($invitationData) . "\n\n";
    
    // Commit transaction
    $pdo->commit();
    
    echo "✅ Seeding completed successfully!\n\n";
    
    // ============================================
    // SUMMARY
    // ============================================
    echo "📊 SEEDING SUMMARY:\n";
    echo "==========================================\n";
    
    // Count records
    $counts = [
        'personil' => $pdo->query("SELECT COUNT(*) FROM personil")->fetchColumn(),
        'project' => $pdo->query("SELECT COUNT(*) FROM project")->fetchColumn(),
        'kategori' => $pdo->query("SELECT COUNT(*) FROM kategori")->fetchColumn(),
        'blog_post' => $pdo->query("SELECT COUNT(*) FROM blog_post")->fetchColumn(),
        'profil_page' => $pdo->query("SELECT COUNT(*) FROM profil_page")->fetchColumn(),
        'join_application' => $pdo->query("SELECT COUNT(*) FROM join_application")->fetchColumn(),
        'personil_invitation' => $pdo->query("SELECT COUNT(*) FROM personil_invitation")->fetchColumn(),
    ];
    
    foreach ($counts as $table => $count) {
        echo sprintf("   %-25s: %d records\n", ucfirst(str_replace('_', ' ', $table)), $count);
    }
    
    echo "==========================================\n\n";
    
    echo "🔐 LOGIN CREDENTIALS:\n";
    echo "==========================================\n";
    echo "Admin:\n";
    echo "   Username: ADMIN001\n";
    echo "   Password: (default password hash)\n\n";
    echo "Dosen:\n";
    echo "   Username: DOSEN001\n";
    echo "   Password: (default password hash)\n\n";
    echo "Talent:\n";
    echo "   Username: 2341760001\n";
    echo "   Password: (default password hash)\n";
    echo "==========================================\n\n";
    
    echo "💡 All accounts use the same password hash.\n";
    echo "🚀 You can now start the application!\n";
    
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Seeding failed: " . $e->getMessage() . "\n";
    exit(1);
}

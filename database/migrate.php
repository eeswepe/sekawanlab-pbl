#!/usr/bin/env php
<?php

/**
 * Database Migration Script
 * Run: php database/migrate.php
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
    echo "🚀 Starting migration...\n\n";

    // Start transaction
    $pdo->beginTransaction();

    // ============================================
    // 1. DROP EXISTING TABLES
    // ============================================
    echo "📦 Dropping existing tables...\n";

    $pdo->exec("DROP TABLE IF EXISTS personil_invitation CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS join_application CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS profil_page CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS blog_post CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS kategori CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS project CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS personil CASCADE");

    echo "   ✓ Tables dropped successfully\n\n";

    // ============================================
    // 2. CREATE PERSONIL TABLE
    // ============================================
    echo "📋 Creating personil table...\n";

    $pdo->exec("
        CREATE TABLE personil(
            id SERIAL PRIMARY KEY,
            -- Authentication fields
            nim_nip VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            -- Profile fields
            nama_lengkap VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'dosen', 'talent')),
            spesialisasi VARCHAR(255),
            email VARCHAR(255) UNIQUE NOT NULL,
            phone VARCHAR(20) UNIQUE NOT NULL,
            location VARCHAR(255),
            tanggal_bergabung DATE,
            bio TEXT,
            skills JSONB,
            foto_url VARCHAR(500),
            -- Timestamps
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $pdo->exec("COMMENT ON COLUMN personil.role IS 'Role personil: admin (full access), dosen (privilege sama dengan admin), talent (personil biasa)'");
    $pdo->exec("CREATE INDEX idx_personil_nim_nip ON personil(nim_nip)");
    $pdo->exec("CREATE INDEX idx_personil_role ON personil(role)");
    $pdo->exec("CREATE INDEX idx_personil_email ON personil(email)");

    echo "   ✓ Personil table created\n\n";

    // ============================================
    // 3. CREATE PROJECT TABLE
    // ============================================
    echo "📋 Creating project table...\n";

    $pdo->exec("
        CREATE TABLE project(
            id SERIAL PRIMARY KEY,
            personil_id INTEGER REFERENCES personil(id) ON DELETE SET NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $pdo->exec("CREATE INDEX idx_project_personil_id ON project(personil_id)");

    echo "   ✓ Project table created\n\n";

    // ============================================
    // 4. CREATE KATEGORI TABLE
    // ============================================
    echo "📋 Creating kategori table...\n";

    $pdo->exec("
        CREATE TABLE kategori (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            post_count INTEGER DEFAULT 0
        )
    ");

    echo "   ✓ Kategori table created\n\n";

    // ============================================
    // 5. CREATE BLOG_POST TABLE
    // ============================================
    echo "📋 Creating blog_post table...\n";

    $pdo->exec("
        CREATE TABLE blog_post(
            id SERIAL PRIMARY KEY,
            penulis_id INTEGER REFERENCES personil(id) ON DELETE SET NULL,
            kategori_id INTEGER REFERENCES kategori(id) ON DELETE SET NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            judul VARCHAR(255) NOT NULL,
            cuplikan TEXT,
            konten TEXT NOT NULL,
            penulis_nama VARCHAR(255) NOT NULL,
            penulis_bio TEXT NOT NULL,
            tanggal_publish TIMESTAMP,
            featured_image_url VARCHAR(500),
            status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft', 'published')),
            reading_time INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $pdo->exec("CREATE INDEX idx_blog_post_penulis_id ON blog_post(penulis_id)");
    $pdo->exec("CREATE INDEX idx_blog_post_kategori_id ON blog_post(kategori_id)");
    $pdo->exec("CREATE INDEX idx_blog_post_slug ON blog_post(slug)");
    $pdo->exec("CREATE INDEX idx_blog_post_status ON blog_post(status)");

    echo "   ✓ Blog_post table created\n\n";

    // ============================================
    // 6. CREATE PROFIL_PAGE TABLE
    // ============================================
    echo "📋 Creating profil_page table...\n";

    $pdo->exec("
        CREATE TABLE profil_page(
            id SERIAL PRIMARY KEY,
            slug VARCHAR(255) NOT NULL UNIQUE,
            page_title VARCHAR(255) NOT NULL,
            page_subtitle VARCHAR(255) NOT NULL,
            featured_image_url VARCHAR(500),
            content_title VARCHAR(255) NOT NULL,
            content_subtitle VARCHAR(255) NOT NULL,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "   ✓ Profil_page table created\n\n";

    // ============================================
    // 7. CREATE JOIN_APPLICATION TABLE
    // ============================================
    echo "📋 Creating join_application table...\n";

    $pdo->exec("
        CREATE TABLE join_application (
            id                SERIAL PRIMARY KEY,
            nama_lengkap      VARCHAR(255)      NOT NULL,
            email             VARCHAR(255)      NOT NULL,
            phone             VARCHAR(20)       NOT NULL,
            nim               VARCHAR(50)       NOT NULL,
            prodi             VARCHAR(10)       NOT NULL,
            semester          INTEGER           NOT NULL,
            alasan_bergabung  TEXT              NOT NULL,
            github_url        VARCHAR(500),
            cv_file_path      VARCHAR(500),
            tanggal_apply     TIMESTAMP         NOT NULL DEFAULT NOW(),
            status            VARCHAR(20)       NOT NULL DEFAULT 'pending',
            assessor_summary  TEXT
        );
    ");

    $pdo->exec("CREATE INDEX idx_join_application_status ON join_application(status)");
    $pdo->exec("CREATE INDEX idx_join_application_email ON join_application(email)");

    echo "   ✓ Join_application table created\n\n";

    // ============================================
    // 8. CREATE PERSONIL_INVITATION TABLE
    // ============================================
    echo "📋 Creating personil_invitation table...\n";

    $pdo->exec("
        CREATE TABLE personil_invitation (
            id SERIAL PRIMARY KEY,
            personil_id INTEGER REFERENCES personil(id) ON DELETE CASCADE,
            secret_key VARCHAR(255) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expires_at TIMESTAMP NOT NULL,
            is_used BOOLEAN DEFAULT FALSE
        )
    ");

    $pdo->exec("CREATE INDEX idx_personil_invitation_secret_key ON personil_invitation(secret_key)");
    $pdo->exec("CREATE INDEX idx_personil_invitation_personil_id ON personil_invitation(personil_id)");

    echo "   ✓ Personil_invitation table created\n\n";

    // ============================================
    // 9. CREATE TRIGGERS
    // ============================================
    echo "⚙️  Creating triggers...\n";

    // Function untuk update timestamp
    $pdo->exec("
        CREATE OR REPLACE FUNCTION update_updated_at_column()
        RETURNS TRIGGER AS \$\$
        BEGIN
            NEW.updated_at = CURRENT_TIMESTAMP;
            RETURN NEW;
        END;
        \$\$ language 'plpgsql'
    ");

    // Trigger untuk personil
    $pdo->exec("
        CREATE TRIGGER update_personil_updated_at
            BEFORE UPDATE ON personil
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column()
    ");

    // Trigger untuk project
    $pdo->exec("
        CREATE TRIGGER update_project_updated_at
            BEFORE UPDATE ON project
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column()
    ");

    // Trigger untuk blog_post
    $pdo->exec("
        CREATE TRIGGER update_blog_post_updated_at
            BEFORE UPDATE ON blog_post
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column()
    ");

    echo "   ✓ Triggers created\n\n";

    // Commit transaction
    $pdo->commit();

    echo "✅ Migration completed successfully!\n";
    echo "\n📊 Summary:\n";
    echo "   - personil\n";
    echo "   - project\n";
    echo "   - kategori\n";
    echo "   - blog_post\n";
    echo "   - profil_page\n";
    echo "   - join_application\n";
    echo "   - personil_invitation\n";
    echo "\n💡 Next step: Run seeder with 'php database/seed.php'\n";
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}

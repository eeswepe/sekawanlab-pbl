-- SEKAWAN Lab Database Structure

-- 1. TABEL PERSONIL
DROP TABLE IF EXISTS personil CASCADE;

CREATE TABLE personil(
    id SERIAL PRIMARY KEY,
    nim_nip VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255),
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_personil_nim_nip ON personil(nim_nip);
CREATE INDEX idx_personil_role ON personil(role);
CREATE INDEX idx_personil_email ON personil(email);

-- 2. TABEL PROJECT
DROP TABLE IF EXISTS project CASCADE;

CREATE TABLE project(
    id SERIAL PRIMARY KEY,
    personil_id INTEGER REFERENCES personil(id) ON DELETE SET NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_project_personil_id ON project(personil_id);

-- 3. TABEL KATEGORI
DROP TABLE IF EXISTS kategori CASCADE;

CREATE TABLE kategori (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    post_count INTEGER DEFAULT 0
);

-- 4. TABEL BLOG POST
DROP TABLE IF EXISTS blog_post CASCADE;

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
);

CREATE INDEX idx_blog_post_penulis_id ON blog_post(penulis_id);
CREATE INDEX idx_blog_post_kategori_id ON blog_post(kategori_id);
CREATE INDEX idx_blog_post_slug ON blog_post(slug);
CREATE INDEX idx_blog_post_status ON blog_post(status);

-- 5. TABEL PROFIL PAGE
DROP TABLE IF EXISTS profil_page CASCADE;

CREATE TABLE profil_page(
    id SERIAL PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    page_title VARCHAR(255) NOT NULL,
    page_subtitle VARCHAR(255) NOT NULL,
    featured_image_url VARCHAR(500),
    content_title VARCHAR(255) NOT NULL,
    content_subtitle VARCHAR(255) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. TABEL JOIN APPLICATION
DROP TABLE IF EXISTS join_application CASCADE;

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


CREATE INDEX idx_join_application_status ON join_application(status);
CREATE INDEX idx_join_application_email ON join_application(email);

-- 7. TABEL PERSONIL INVITATION
DROP TABLE IF EXISTS personil_invitation CASCADE;

CREATE TABLE personil_invitation (
    id SERIAL PRIMARY KEY,
    personil_id INTEGER REFERENCES personil(id) ON DELETE CASCADE,
    secret_key VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_used BOOLEAN DEFAULT FALSE
);

CREATE INDEX idx_personil_invitation_secret_key ON personil_invitation(secret_key);
CREATE INDEX idx_personil_invitation_personil_id ON personil_invitation(personil_id);

-- 8. VIEW LOG AKTIVITAS
CREATE OR REPLACE VIEW view_log_aktivitas AS
SELECT 
    'blog' AS type,
    p.nama_lengkap AS nama,
    'Menambahkan Blog Baru' AS aktivitas,
    bp.judul AS target,
    bp.status,
    bp.created_at AS waktu
FROM blog_post bp
JOIN personil p ON bp.penulis_id = p.id

UNION ALL

SELECT
    'application' AS type,
    ja.nama_lengkap AS nama,
    'Mengajukan Permintaan Bergabung' AS aktivitas,
    ja.email AS target,
    ja.status,
    ja.tanggal_apply AS waktu
FROM join_application ja;

-- TRIGGERS
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

DROP TRIGGER IF EXISTS update_personil_updated_at ON personil;
CREATE TRIGGER update_personil_updated_at
    BEFORE UPDATE ON personil
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

DROP TRIGGER IF EXISTS update_project_updated_at ON project;
CREATE TRIGGER update_project_updated_at
    BEFORE UPDATE ON project
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

DROP TRIGGER IF EXISTS update_blog_post_updated_at ON blog_post;
CREATE TRIGGER update_blog_post_updated_at
    BEFORE UPDATE ON blog_post
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- user table
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) CHECK (role IN ('admin', 'personil')) NOT NULL DEFAULT 'personil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- personil table

CREATE TABLE personil(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL CHECK (role IN ('dosen', 'talent')),
    spesialisasi VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    location VARCHAR(255),
    tanggal_bergabung DATE,
    bio TEXT,
    skillks JSONB,
    foto_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- project table
CREATE TABLE project(
    id SERIAL PRIMARY KEY,
    personil_id INTEGER REFERENCES personil(id) ON DELETE SET NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- kategori table
CREATE TABLE kategori (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    post_count INTEGER DEFAULT 0,
);

-- blog table
CREATE TABLE blog_post(
    id SERIAL PRIMARY KEY,
    penulis_id INTEGER REFERENCES personil(id) ,
    kategori_id INTEGER REFERENCES kategori(id) ,
    slug VARCHAR(255) NOT NULL,
    judul VARCHAR(255) NOT NULL,
    cuplikan TEXT;
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

-- profil page table
CREATE TABLE profil_page(
    id SERIAL PRIMARY KEY,
    slug VARCHAR(255) NOT NULL,
    page_title VARCHAR(255) NOT NULL,
    page_subtitle VARCHAR(255) NOT NULL,
    featured_image_url VARCHAR(500),
    content_title VARCHAR(255) NOT NULL,
    content_subtitle VARCHAR(255) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- join application table
CREATE TABLE join_application (
    id SERIAL PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    nim VARCHAR(50) NOT NULL,
    prodi VARCHAR(10) NOT NULL CHECK (prodi IN ('TI', 'SIB', 'PPLS')),
    semester INTEGER NOT NULL CHECK (semester >= 1 AND semester <= 8),
    alasan_bergabung TEXT NOT NULL,
    github_url VARCHAR(500),
    cv_file_path VARCHAR(500),
    tanggal_apply TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'reviewed', 'accepted', 'rejected')),
    catatan_admin TEXT
);

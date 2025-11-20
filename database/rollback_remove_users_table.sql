-- ============================================
-- Rollback Migration: Restore Users Table
-- Mengembalikan struktur database ke kondisi semula
-- ============================================
-- PERHATIAN: Script ini untuk rollback jika migrasi gagal
-- Pastikan Anda memiliki backup data sebelum menjalankan migration

-- Langkah 1: Buat ulang tabel users
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) CHECK (role IN ('admin', 'personil')) NOT NULL DEFAULT 'personil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Langkah 2: Tambah kembali kolom user_id ke personil
ALTER TABLE personil ADD COLUMN IF NOT EXISTS user_id INTEGER;

-- Langkah 3: Restore constraint role ke dosen/talent saja
ALTER TABLE personil DROP CONSTRAINT IF EXISTS personil_role_check;
ALTER TABLE personil 
ADD CONSTRAINT personil_role_check CHECK (role IN ('dosen', 'talent'));

-- Langkah 4: Restore data dari personil ke users (jika masih ada data)
-- INSERT INTO users (username, password, role)
-- SELECT nim_nip, password, 
--        CASE WHEN role = 'admin' THEN 'admin' ELSE 'personil' END
-- FROM personil 
-- WHERE nim_nip IS NOT NULL;

-- Langkah 5: Update user_id di personil dengan id dari users
-- UPDATE personil p
-- SET user_id = u.id
-- FROM users u
-- WHERE p.nim_nip = u.username;

-- Langkah 6: Tambah foreign key constraint
ALTER TABLE personil 
ADD CONSTRAINT personil_user_id_fkey 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Langkah 7: Drop kolom yang ditambahkan saat migration
ALTER TABLE personil 
DROP COLUMN IF EXISTS nim_nip,
DROP COLUMN IF EXISTS password;

-- Langkah 8: Update role admin kembali ke dosen (jika ada)
-- UPDATE personil SET role = 'dosen' WHERE role = 'admin';

-- Langkah 9: Drop index yang dibuat saat migration
DROP INDEX IF EXISTS idx_personil_nim_nip;

-- ============================================
-- Rollback selesai!
-- Database dikembalikan ke struktur semula
-- ============================================

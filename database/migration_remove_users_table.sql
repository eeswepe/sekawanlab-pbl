-- ============================================
-- Migration: Remove Users Table
-- Memindahkan autentikasi ke tabel personil
-- ============================================

-- Langkah 1: Tambah kolom nim_nip dan password ke tabel personil
ALTER TABLE personil 
ADD COLUMN IF NOT EXISTS nim_nip VARCHAR(50) UNIQUE,
ADD COLUMN IF NOT EXISTS password VARCHAR(255);

-- Langkah 2: Update constraint role untuk include 'admin'
-- Drop constraint lama
ALTER TABLE personil DROP CONSTRAINT IF EXISTS personil_role_check;

-- Buat constraint baru dengan admin, dosen, talent
ALTER TABLE personil 
ADD CONSTRAINT personil_role_check CHECK (role IN ('admin', 'dosen', 'talent'));

-- Langkah 3: Migrasi data dari users ke personil
-- Mapping: users.role 'admin' → personil.role 'admin'
--          users.role 'personil' + existing role → keep existing role (dosen/talent)
UPDATE personil p
SET 
    nim_nip = u.username,
    password = u.password,
    role = CASE 
        WHEN u.role = 'admin' THEN 'admin'
        ELSE p.role  -- keep existing role (dosen/talent)
    END
FROM users u
WHERE p.user_id = u.id;

-- Langkah 4: Untuk personil yang belum memiliki user_id (jika ada), set nilai default
-- UPDATE personil 
-- SET 
--     nim_nip = 'TEMP_' || id::text,
--     password = '$2y$10$defaulthashpassword',  -- Ganti dengan hash password default
--     role = COALESCE(role, 'talent')  -- default ke talent jika NULL
-- WHERE nim_nip IS NULL;

-- Langkah 5: Set kolom nim_nip dan password menjadi NOT NULL setelah semua data termigrasi
ALTER TABLE personil 
ALTER COLUMN nim_nip SET NOT NULL,
ALTER COLUMN password SET NOT NULL;

-- Langkah 6: Hapus foreign key constraint user_id dari tabel personil
ALTER TABLE personil DROP CONSTRAINT IF EXISTS personil_user_id_fkey;

-- Langkah 7: Hapus kolom user_id dari tabel personil
ALTER TABLE personil DROP COLUMN IF EXISTS user_id;

-- Langkah 8: Drop tabel users
DROP TABLE IF EXISTS users;

-- Langkah 9: Buat index untuk performa query login
CREATE INDEX IF NOT EXISTS idx_personil_nim_nip ON personil(nim_nip);
CREATE INDEX IF NOT EXISTS idx_personil_role ON personil(role);

-- ============================================
-- Selesai! Struktur database baru:
-- - Tabel users dihapus
-- - Tabel personil sekarang memiliki nim_nip (identifier login) dan password
-- - role sekarang bisa: admin, dosen, talent
--   * admin: full access
--   * dosen: privilege sama dengan admin (bisa manage)
--   * talent: personil biasa
-- ============================================

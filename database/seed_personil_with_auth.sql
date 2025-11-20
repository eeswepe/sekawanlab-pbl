-- ============================================
-- Seed Data: Personil dengan NIM/NIP
-- ============================================
-- Password default untuk semua: "password123"
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- ADMIN
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    'ADMIN001',
    '$2y$12$fSU0eTI2TW8KiGX0M.9lt.MTP6pBzrxnvJm7iksvO.DIsZM5fPJlS',
    'Administrator SEKAWAN Lab',
    'admin',
    'Lab Management',
    'admin@sekawanlab.com',
    '081234567890',
    'Malang, Jawa Timur',
    '2020-01-01',
    'Administrator dan pengelola SEKAWAN Lab',
    '["Management", "Administration", "Leadership"]'::jsonb,
    NULL
);

-- DOSEN 1 (memiliki privilege sama dengan admin)
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    'NIP001234567',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Dr. Budi Santoso, S.Kom., M.Kom',
    'dosen',
    'Software Engineering & AI',
    'budi.santoso@polinema.ac.id',
    '081234567891',
    'Malang, Jawa Timur',
    '2015-03-15',
    'Dosen senior di bidang Software Engineering dengan spesialisasi dalam Artificial Intelligence dan Machine Learning. Aktif dalam penelitian dan pengembangan aplikasi berbasis AI.',
    '["Python", "Machine Learning", "Deep Learning", "TensorFlow", "PyTorch", "Computer Vision"]'::jsonb,
    NULL
);

-- DOSEN 2 (memiliki privilege sama dengan admin)
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    'NIP009876543',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Siti Nurhaliza, S.T., M.T',
    'dosen',
    'Web Development & Cloud Computing',
    'siti.nurhaliza@polinema.ac.id',
    '081234567892',
    'Malang, Jawa Timur',
    '2018-08-01',
    'Dosen muda yang berfokus pada Web Development modern dan Cloud Computing. Berpengalaman dalam mengajar dan membimbing mahasiswa dalam proyek-proyek web.',
    '["JavaScript", "React", "Node.js", "PHP", "Laravel", "AWS", "Docker", "Kubernetes"]'::jsonb,
    NULL
);

-- TALENT 1
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    '244107020001',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Ahmad Rizki Pratama',
    'talent',
    'Full Stack Developer',
    'ahmad.rizki@student.polinema.ac.id',
    '081234567893',
    'Malang, Jawa Timur',
    '2023-09-01',
    'Mahasiswa Teknik Informatika semester 5. Passionate dalam web development dan mobile development. Aktif dalam berbagai kompetisi programming.',
    '["JavaScript", "TypeScript", "React", "Next.js", "Node.js", "Express", "MongoDB", "PostgreSQL", "Git"]'::jsonb,
    NULL
);

-- TALENT 2
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    '244107020002',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Putri Ayu Lestari',
    'talent',
    'Mobile Developer',
    'putri.ayu@student.polinema.ac.id',
    '081234567894',
    'Malang, Jawa Timur',
    '2023-09-01',
    'Mahasiswa Sistem Informasi Bisnis semester 5. Fokus pada mobile app development dengan Flutter dan React Native. Senang mengeksplorasi UI/UX design.',
    '["Flutter", "Dart", "React Native", "Firebase", "UI/UX Design", "Figma", "Git"]'::jsonb,
    NULL
);

-- TALENT 3
INSERT INTO personil (
    nim_nip, 
    password, 
    nama_lengkap, 
    role, 
    spesialisasi, 
    email, 
    phone, 
    location, 
    tanggal_bergabung, 
    bio, 
    skills,
    foto_url
) VALUES 
(
    '244107020102',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Andi Setiawan',
    'talent',
    'Backend Developer',
    '244107020102@student.polinema.ac.id',
    '081234567895',
    'Malang, Jawa Timur',
    '2024-02-15',
    'Mahasiswa PPLS yang tertarik dengan backend development dan database design. Sedang belajar tentang microservices dan system design.',
    '["PHP", "Laravel", "PostgreSQL", "MySQL", "Redis", "RESTful API", "Docker", "Linux"]'::jsonb,
    NULL
);

-- ============================================
-- Credentials untuk Testing:
-- ============================================
-- 
-- ADMIN (full access):
--   NIM/NIP: ADMIN001
--   Password: password123
-- 
-- DOSEN (privilege = admin, bisa manage semua):
--   NIM/NIP: NIP001234567 atau NIP009876543
--   Password: password123
-- 
-- TALENT (personil biasa):
--   NIM/NIP: 244107020001, 244107020002, atau 244107020102
--   Password: password123
-- 
-- ============================================

-- Verifikasi data
SELECT 
    nim_nip,
    nama_lengkap,
    role,
    email
FROM personil
ORDER BY 
    CASE role 
        WHEN 'admin' THEN 1
        WHEN 'dosen' THEN 2
        WHEN 'talent' THEN 3
    END,
    nama_lengkap;

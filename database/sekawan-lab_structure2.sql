-- ============================================
-- VIEWS & STORED PROCEDURES (VERSI RINGKAS)
-- Software Engineering Laboratory Database
-- ============================================

-- ============================================
-- SECTION 1: VIEWS (Hanya yang Penting)
-- ============================================

-- ------------------------------------------------
-- 1. View Personil Lengkap
-- ------------------------------------------------
-- Untuk: Halaman personil list & detail
CREATE OR REPLACE VIEW v_personil_lengkap AS
SELECT
    p.id,
    p.nama_lengkap,
    p.role,
    p.spesialisasi,
    p.email,
    p.phone,
    p.location,
    p.tanggal_bergabung,
    p.bio,
    p.skillks,
    p.foto_url,
    u.username,
    -- Hitung jumlah project
    (SELECT COUNT(*) FROM project WHERE personil_id = p.id) as total_projects,
    -- Hitung jumlah blog posts
    (SELECT COUNT(*) FROM blog_post WHERE penulis_id = p.id AND status = 'published') as total_blog_posts
FROM personil p
LEFT JOIN users u ON p.user_id = u.id;

-- ------------------------------------------------
-- 2. View Blog Post Published
-- ------------------------------------------------
-- Untuk: Public blog list
CREATE OR REPLACE VIEW v_blog_published AS
SELECT
    bp.id,
    bp.slug,
    bp.judul,
    bp.cuplikan,
    bp.tanggal_publish,
    bp.featured_image_url,
    bp.reading_time,
    k.name as kategori_nama,
    bp.penulis_nama,
    p.foto_url as penulis_foto
FROM blog_post bp
LEFT JOIN kategori k ON bp.kategori_id = k.id
LEFT JOIN personil p ON bp.penulis_id = p.id
WHERE bp.status = 'published'
ORDER BY bp.tanggal_publish DESC;

-- ------------------------------------------------
-- 3. View Admin Dashboard Statistics
-- ------------------------------------------------
-- Untuk: Admin dashboard stats cards
CREATE OR REPLACE VIEW v_admin_dashboard_stats AS
SELECT
    (SELECT COUNT(*) FROM personil) as total_personil,
    (SELECT COUNT(*) FROM personil WHERE role = 'dosen') as total_dosen,
    (SELECT COUNT(*) FROM personil WHERE role = 'talent') as total_talent,
    (SELECT COUNT(*) FROM blog_post WHERE status = 'published') as total_published_posts,
    (SELECT COUNT(*) FROM blog_post WHERE status = 'draft') as total_draft_posts,
    (SELECT COUNT(*) FROM join_application WHERE status = 'pending') as pending_applications;

-- ------------------------------------------------
-- 4. View Pending Applications
-- ------------------------------------------------
-- Untuk: Admin review aplikasi
CREATE OR REPLACE VIEW v_pending_applications AS
SELECT
    ja.id,
    ja.nama_lengkap,
    ja.email,
    ja.prodi,
    ja.semester,
    ja.status,
    ja.tanggal_apply,
    EXTRACT(DAY FROM (CURRENT_TIMESTAMP - ja.tanggal_apply)) as days_pending
FROM join_application ja
WHERE ja.status = 'pending'
ORDER BY ja.tanggal_apply ASC;


-- ============================================
-- SECTION 2: STORED PROCEDURES (Hanya yang Penting)
-- ============================================

-- ------------------------------------------------
-- 1. SP: Publish Blog Post
-- ------------------------------------------------
CREATE OR REPLACE FUNCTION sp_publish_blog_post(
    p_blog_id INTEGER
)
RETURNS TABLE(
    success BOOLEAN,
    message TEXT
) AS $$
BEGIN
    -- Update status dan tanggal publish
    UPDATE blog_post
    SET
        status = 'published',
        tanggal_publish = CURRENT_TIMESTAMP,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_blog_id;

    -- Update kategori post count
    UPDATE kategori k
    SET post_count = (
        SELECT COUNT(*)
        FROM blog_post
        WHERE kategori_id = k.id AND status = 'published'
    )
    WHERE k.id = (SELECT kategori_id FROM blog_post WHERE id = p_blog_id);

    RETURN QUERY SELECT TRUE, 'Blog post berhasil dipublish'::TEXT;
END;
$$ LANGUAGE plpgsql;

-- ------------------------------------------------
-- 2. SP: Calculate Reading Time
-- ------------------------------------------------
-- Menghitung reading time (200 kata/menit)
CREATE OR REPLACE FUNCTION sp_calculate_reading_time(
    p_konten TEXT
)
RETURNS INTEGER AS $$
DECLARE
    v_word_count INTEGER;
    v_reading_time INTEGER;
BEGIN
    -- Hitung jumlah kata
    v_word_count := array_length(regexp_split_to_array(p_konten, '\s+'), 1);

    -- Hitung reading time (minimal 1 menit)
    v_reading_time := GREATEST(CEIL(v_word_count / 200.0), 1);

    RETURN v_reading_time;
END;
$$ LANGUAGE plpgsql;

-- ------------------------------------------------
-- 3. SP: Approve/Reject Join Application
-- ------------------------------------------------
CREATE OR REPLACE FUNCTION sp_update_application_status(
    p_application_id INTEGER,
    p_status VARCHAR(20),  -- 'accepted' atau 'rejected'
    p_catatan_admin TEXT DEFAULT NULL
)
RETURNS TABLE(
    success BOOLEAN,
    message TEXT
) AS $$
BEGIN
    -- Validasi status
    IF p_status NOT IN ('accepted', 'rejected') THEN
        RETURN QUERY SELECT FALSE, 'Status harus accepted atau rejected'::TEXT;
        RETURN;
    END IF;

    -- Update status
    UPDATE join_application
    SET
        status = p_status,
        catatan_admin = p_catatan_admin
    WHERE id = p_application_id;

    RETURN QUERY SELECT TRUE, 'Status aplikasi berhasil diupdate'::TEXT;
END;
$$ LANGUAGE plpgsql;

-- ------------------------------------------------
-- 4. SP: Get Related Blog Posts
-- ------------------------------------------------
CREATE OR REPLACE FUNCTION sp_get_related_posts(
    p_blog_id INTEGER,
    p_limit INTEGER DEFAULT 3
)
RETURNS TABLE(
    id INTEGER,
    slug VARCHAR(255),
    judul VARCHAR(255),
    featured_image_url VARCHAR(500),
    kategori_nama VARCHAR(100)
) AS $$
BEGIN
    RETURN QUERY
    SELECT
        bp.id,
        bp.slug,
        bp.judul,
        bp.featured_image_url,
        k.name as kategori_nama
    FROM blog_post bp
    LEFT JOIN kategori k ON bp.kategori_id = k.id
    WHERE bp.kategori_id = (SELECT kategori_id FROM blog_post WHERE id = p_blog_id)
        AND bp.id != p_blog_id
        AND bp.status = 'published'
    ORDER BY bp.tanggal_publish DESC
    LIMIT p_limit;
END;
$$ LANGUAGE plpgsql;


-- ============================================
-- SECTION 3: TRIGGER (Hanya 1 yang Penting)
-- ============================================

-- ------------------------------------------------
-- Trigger: Auto-update kategori post_count
-- ------------------------------------------------
CREATE OR REPLACE FUNCTION trigger_update_kategori_count()
RETURNS TRIGGER AS $$
BEGIN
    -- Update count untuk kategori lama (jika update/delete)
    IF (TG_OP = 'UPDATE' OR TG_OP = 'DELETE') AND OLD.kategori_id IS NOT NULL THEN
        UPDATE kategori
        SET post_count = (
            SELECT COUNT(*)
            FROM blog_post
            WHERE kategori_id = OLD.kategori_id AND status = 'published'
        )
        WHERE id = OLD.kategori_id;
    END IF;

    -- Update count untuk kategori baru (jika insert/update)
    IF (TG_OP = 'INSERT' OR TG_OP = 'UPDATE') AND NEW.kategori_id IS NOT NULL THEN
        UPDATE kategori
        SET post_count = (
            SELECT COUNT(*)
            FROM blog_post
            WHERE kategori_id = NEW.kategori_id AND status = 'published'
        )
        WHERE id = NEW.kategori_id;
    END IF;

    RETURN COALESCE(NEW, OLD);
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_update_kategori_count
AFTER INSERT OR UPDATE OR DELETE ON blog_post
FOR EACH ROW
EXECUTE FUNCTION trigger_update_kategori_count();


-- ============================================
-- SECTION 4: CTE (Common Table Expression)
-- ============================================

-- ------------------------------------------------
-- CTE: Ranking Blog Posts by Kategori
-- ------------------------------------------------
-- Untuk: Menampilkan blog posts dengan ranking per kategori
-- Berguna untuk: Featured posts, top posts per kategori

/*
Contoh Query dengan CTE:
*/

WITH blog_ranking AS (
    SELECT
        bp.id,
        bp.slug,
        bp.judul,
        bp.cuplikan,
        bp.tanggal_publish,
        bp.featured_image_url,
        bp.penulis_nama,
        k.name as kategori_nama,
        k.id as kategori_id,
        -- Ranking berdasarkan tanggal publish per kategori
        ROW_NUMBER() OVER (
            PARTITION BY k.id
            ORDER BY bp.tanggal_publish DESC
        ) as rank_in_category,
        -- Total posts dalam kategori ini
        COUNT(*) OVER (PARTITION BY k.id) as total_in_category
    FROM blog_post bp
    JOIN kategori k ON bp.kategori_id = k.id
    WHERE bp.status = 'published'
)
-- Contoh: Ambil 3 blog teratas dari setiap kategori
SELECT
    id,
    judul,
    kategori_nama,
    rank_in_category,
    total_in_category
FROM blog_ranking
WHERE rank_in_category <= 3
ORDER BY kategori_id, rank_in_category;

/*
Contoh lain: CTE untuk Personil Produktif
*/

WITH personil_stats AS (
    SELECT
        p.id,
        p.nama_lengkap,
        p.role,
        p.foto_url,
        COUNT(DISTINCT pr.id) as total_projects,
        COUNT(DISTINCT bp.id) as total_blogs,
        -- Hitung produktivitas score
        (COUNT(DISTINCT pr.id) * 2 + COUNT(DISTINCT bp.id)) as productivity_score
    FROM personil p
    LEFT JOIN project pr ON p.id = pr.personil_id
    LEFT JOIN blog_post bp ON p.id = bp.penulis_id AND bp.status = 'published'
    GROUP BY p.id, p.nama_lengkap, p.role, p.foto_url
)
-- Ambil 5 personil paling produktif
SELECT
    nama_lengkap,
    role,
    total_projects,
    total_blogs,
    productivity_score
FROM personil_stats
WHERE productivity_score > 0
ORDER BY productivity_score DESC
LIMIT 5;


-- ============================================
-- CONTOH PENGGUNAAN
-- ============================================

/*
-- View Personil:
SELECT * FROM v_personil_lengkap WHERE role = 'dosen';

-- View Blog Published:
SELECT * FROM v_blog_published LIMIT 10;

-- View Dashboard Stats:
SELECT * FROM v_admin_dashboard_stats;

-- View Pending Applications:
SELECT * FROM v_pending_applications;

-- Publish Blog:
SELECT * FROM sp_publish_blog_post(1);

-- Calculate Reading Time:
SELECT sp_calculate_reading_time('Konten blog yang panjang...');

-- Approve Application:
SELECT * FROM sp_update_application_status(1, 'accepted', 'Memenuhi syarat');

-- Reject Application:
SELECT * FROM sp_update_application_status(2, 'rejected', 'Tidak memenuhi syarat');

-- Get Related Posts:
SELECT * FROM sp_get_related_posts(5, 3);
*/

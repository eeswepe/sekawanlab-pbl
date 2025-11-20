<?php
/**
 * Data Migration Script
 * 
 * Script ini untuk memigrasikan data dari tabel users ke personil
 * JALANKAN SCRIPT INI SEBELUM menjalankan migration SQL
 * 
 * Cara menjalankan:
 * php database/migrate_users_to_personil.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

try {
    echo "=================================================\n";
    echo "Data Migration: Users → Personil\n";
    echo "=================================================\n\n";

    $db = Database::getConnection();
    
    // Langkah 1: Cek apakah tabel users ada
    echo "[1/6] Checking if users table exists...\n";
    $checkTable = $db->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'users'
    )");
    $tableExists = $checkTable->fetchColumn();
    
    if (!$tableExists) {
        echo "❌ Tabel users tidak ditemukan. Migration dibatalkan.\n";
        exit(1);
    }
    echo "✅ Tabel users ditemukan.\n\n";

    // Langkah 2: Tambah kolom baru ke personil
    echo "[2/6] Adding new columns to personil table...\n";
    $db->exec("
        ALTER TABLE personil 
        ADD COLUMN IF NOT EXISTS nim_nip VARCHAR(50),
        ADD COLUMN IF NOT EXISTS password VARCHAR(255)
    ");
    echo "✅ Kolom nim_nip dan password ditambahkan.\n\n";

    // Update role constraint
    echo "[2.5/6] Updating role constraint to include 'admin'...\n";
    $db->exec("
        ALTER TABLE personil DROP CONSTRAINT IF EXISTS personil_role_check;
        ALTER TABLE personil 
        ADD CONSTRAINT personil_role_check CHECK (role IN ('admin', 'dosen', 'talent'))
    ");
    echo "✅ Role constraint diupdate (admin, dosen, talent).\n\n";

    // Langkah 3: Hitung jumlah user yang akan dimigrasi
    echo "[3/6] Counting users to migrate...\n";
    $countStmt = $db->query("
        SELECT COUNT(*) FROM personil p
        INNER JOIN users u ON p.user_id = u.id
    ");
    $totalUsers = (int) $countStmt->fetchColumn();
    echo "📊 Total user yang akan dimigrasi: {$totalUsers}\n\n";

    if ($totalUsers === 0) {
        echo "⚠️  Tidak ada data user yang terhubung dengan personil.\n";
        echo "    Anda perlu membuat personil manual atau mengisi data secara manual.\n\n";
    }

    // Langkah 4: Migrasi data dari users ke personil
    echo "[4/6] Migrating data from users to personil...\n";
    $db->beginTransaction();
    
    try {
        $migrateStmt = $db->exec("
            UPDATE personil p
            SET 
                nim_nip = u.username,
                password = u.password,
                role = CASE 
                    WHEN u.role = 'admin' THEN 'admin'
                    ELSE p.role
                END
            FROM users u
            WHERE p.user_id = u.id
        ");
        
        $db->commit();
        echo "✅ Data berhasil dimigrasi: {$totalUsers} records.\n\n";
    } catch (Exception $e) {
        $db->rollBack();
        echo "❌ Gagal migrasi data: " . $e->getMessage() . "\n";
        exit(1);
    }

    // Langkah 5: Verifikasi data
    echo "[5/6] Verifying migrated data...\n";
    $verifyStmt = $db->query("
        SELECT COUNT(*) FROM personil 
        WHERE nim_nip IS NOT NULL AND password IS NOT NULL
    ");
    $migratedCount = (int) $verifyStmt->fetchColumn();
    echo "📊 Total personil dengan nim_nip dan password: {$migratedCount}\n";
    
    if ($migratedCount !== $totalUsers) {
        echo "⚠️  WARNING: Jumlah data yang dimigrasi tidak sesuai!\n";
        echo "    Expected: {$totalUsers}, Got: {$migratedCount}\n";
    } else {
        echo "✅ Verifikasi berhasil!\n\n";
    }

    // Langkah 6: Tampilkan sample data
    echo "[6/6] Sample migrated data:\n";
    $sampleStmt = $db->query("
        SELECT id, nim_nip, nama_lengkap, role
        FROM personil 
        WHERE nim_nip IS NOT NULL 
        LIMIT 5
    ");
    $samples = $sampleStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "┌─────┬──────────────┬────────────────────────┬─────────────┐\n";
    echo "│ ID  │ NIM/NIP      │ Nama Lengkap           │ Role        │\n";
    echo "├─────┼──────────────┼────────────────────────┼─────────────┤\n";
    foreach ($samples as $row) {
        printf(
            "│ %-3d │ %-12s │ %-22s │ %-11s │\n",
            $row['id'],
            substr($row['nim_nip'], 0, 12),
            substr($row['nama_lengkap'], 0, 22),
            $row['role']
        );
    }
    echo "└─────┴──────────────┴────────────────────────┴─────────────┘\n\n";

    echo "=================================================\n";
    echo "✅ MIGRATION COMPLETED SUCCESSFULLY!\n";
    echo "=================================================\n\n";
    echo "📝 Next steps:\n";
    echo "   1. Jalankan migration SQL:\n";
    echo "      psql -U your_user -d your_database -f database/migration_remove_users_table.sql\n\n";
    echo "   2. Replace PersonilModel.php dengan PersonilModel_NEW.php\n";
    echo "   3. Replace AuthService.php dengan AuthService_NEW.php\n";
    echo "   4. Update file-file lain yang masih menggunakan UserModel\n";
    echo "   5. Test login dengan nim_nip dan password\n\n";

} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

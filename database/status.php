#!/usr/bin/env php
<?php

/**
 * Database Status Script
 * Shows current database tables and record counts
 * Usage: php database/status.php
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
    
    echo "╔═══════════════════════════════════════════╗\n";
    echo "║    SEKAWAN Lab Database Status Report    ║\n";
    echo "╚═══════════════════════════════════════════╝\n\n";
    
    echo "📊 Database: {$config['database']}\n";
    echo "🖥️  Host: {$config['host']}:{$config['port']}\n";
    echo "👤 User: {$config['username']}\n\n";
    
    // Get all tables
    $query = "
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_type = 'BASE TABLE'
        ORDER BY table_name
    ";
    
    $tables = $pdo->query($query)->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠️  No tables found in database.\n";
        echo "💡 Run 'php database/setup.php' to create tables.\n";
        exit(0);
    }
    
    echo "📋 TABLES AND RECORD COUNTS:\n";
    echo "==========================================\n";
    
    $totalRecords = 0;
    $tableStats = [];
    
    foreach ($tables as $table) {
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            $totalRecords += $count;
            $tableStats[$table] = $count;
            
            // Get size of table
            $sizeQuery = "
                SELECT pg_size_pretty(pg_total_relation_size('$table')) as size
            ";
            $size = $pdo->query($sizeQuery)->fetch()['size'];
            
            printf("   %-25s : %6d records (%s)\n", $table, $count, $size);
        } catch (PDOException $e) {
            printf("   %-25s : ERROR\n", $table);
        }
    }
    
    echo "==========================================\n";
    echo sprintf("   %-25s : %6d records\n", "TOTAL", $totalRecords);
    echo "\n";
    
    // Show detailed stats for main tables
    echo "📈 DETAILED STATISTICS:\n";
    echo "==========================================\n";
    
    // Personil by role
    if (in_array('personil', $tables)) {
        echo "\n👥 Personil by Role:\n";
        $roleStats = $pdo->query("
            SELECT role, COUNT(*) as count 
            FROM personil 
            GROUP BY role 
            ORDER BY role
        ")->fetchAll();
        
        foreach ($roleStats as $stat) {
            printf("   %-15s: %d\n", ucfirst($stat['role']), $stat['count']);
        }
    }
    
    // Blog posts by status
    if (in_array('blog_post', $tables)) {
        echo "\n📝 Blog Posts by Status:\n";
        $blogStats = $pdo->query("
            SELECT status, COUNT(*) as count 
            FROM blog_post 
            GROUP BY status 
            ORDER BY status
        ")->fetchAll();
        
        foreach ($blogStats as $stat) {
            printf("   %-15s: %d\n", ucfirst($stat['status']), $stat['count']);
        }
    }
    
    // Kategori with post counts
    if (in_array('kategori', $tables)) {
        echo "\n📁 Kategori with Post Counts:\n";
        $kategoriStats = $pdo->query("
            SELECT name, post_count 
            FROM kategori 
            ORDER BY post_count DESC 
            LIMIT 5
        ")->fetchAll();
        
        foreach ($kategoriStats as $stat) {
            printf("   %-20s: %d posts\n", $stat['name'], $stat['post_count']);
        }
    }
    
    // Join applications by status
    if (in_array('join_application', $tables)) {
        echo "\n📋 Join Applications by Status:\n";
        $appStats = $pdo->query("
            SELECT status, COUNT(*) as count 
            FROM join_application 
            GROUP BY status 
            ORDER BY 
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'reviewed' THEN 2
                    WHEN 'accepted' THEN 3
                    WHEN 'rejected' THEN 4
                    ELSE 5
                END
        ")->fetchAll();
        
        foreach ($appStats as $stat) {
            $statusLabel = ucfirst($stat['status'] ?? 'unknown');
            printf("   %-15s: %d\n", $statusLabel, $stat['count']);
        }
    }
    
    echo "\n==========================================\n";
    
    // Database size
    echo "\n💾 Database Size:\n";
    $dbSize = $pdo->query("
        SELECT pg_size_pretty(pg_database_size(current_database())) as size
    ")->fetch()['size'];
    echo "   Total: $dbSize\n";
    
    echo "\n";
    
    // Show recent activity
    if (in_array('blog_post', $tables)) {
        echo "🕒 Recent Blog Posts:\n";
        echo "==========================================\n";
        $recentPosts = $pdo->query("
            SELECT judul, tanggal_publish, status 
            FROM blog_post 
            ORDER BY tanggal_publish DESC 
            LIMIT 3
        ")->fetchAll();
        
        if (!empty($recentPosts)) {
            foreach ($recentPosts as $post) {
                $date = date('Y-m-d H:i', strtotime($post['tanggal_publish']));
                $title = strlen($post['judul']) > 40 ? substr($post['judul'], 0, 37) . '...' : $post['judul'];
                echo "   • $title\n";
                echo "     $date | " . ucfirst($post['status']) . "\n\n";
            }
        } else {
            echo "   No blog posts yet.\n\n";
        }
    }
    
    if (in_array('join_application', $tables)) {
        echo "📬 Recent Applications:\n";
        echo "==========================================\n";
        $recentApps = $pdo->query("
            SELECT nama_lengkap, tanggal_apply, status 
            FROM join_application 
            ORDER BY tanggal_apply DESC 
            LIMIT 3
        ")->fetchAll();
        
        if (!empty($recentApps)) {
            foreach ($recentApps as $app) {
                $date = date('Y-m-d H:i', strtotime($app['tanggal_apply']));
                echo "   • {$app['nama_lengkap']}\n";
                echo "     $date | " . ucfirst($app['status']) . "\n\n";
            }
        } else {
            echo "   No applications yet.\n\n";
        }
    }
    
    echo "✅ Status check completed!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Make sure:\n";
    echo "   - PostgreSQL service is running\n";
    echo "   - Database exists\n";
    echo "   - Configuration in config/database.php is correct\n";
    exit(1);
}

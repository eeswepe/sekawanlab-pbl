#!/usr/bin/env php
<?php

/**
 * Database Reset Script
 * Drops all tables from the database
 * Usage: php database/reset.php
 */

// Load database config
$config = require_once __DIR__ . '/../config/database.php';

echo "╔═══════════════════════════════════════════╗\n";
echo "║     SEKAWAN Lab Database Reset Script    ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

echo "⚠️  WARNING: This will DROP all tables and DELETE all data!\n";
echo "Database: {$config['database']}\n";
echo "Host: {$config['host']}\n\n";

echo "Are you absolutely sure? (yes/no): ";

$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
fclose($handle);

if (strtolower($line) !== 'yes') {
    echo "\n❌ Reset cancelled.\n";
    exit(0);
}

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
    
    echo "\n🔗 Connected to database: {$config['database']}\n";
    echo "🗑️  Dropping all tables...\n\n";
    
    // Drop all tables
    $tables = [
        'personil_invitation',
        'join_application',
        'profil_page',
        'blog_post',
        'kategori',
        'project',
        'personil'
    ];
    
    foreach ($tables as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS $table CASCADE");
            echo "   ✓ Dropped table: $table\n";
        } catch (PDOException $e) {
            echo "   ⚠️  Could not drop table $table: " . $e->getMessage() . "\n";
        }
    }
    
    // Drop trigger function
    try {
        $pdo->exec("DROP FUNCTION IF EXISTS update_updated_at_column() CASCADE");
        echo "   ✓ Dropped trigger function\n";
    } catch (PDOException $e) {
        echo "   ⚠️  Could not drop trigger function: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Database reset completed successfully!\n";
    echo "\n💡 Run 'php database/setup.php' to recreate the database.\n";
    
} catch (PDOException $e) {
    echo "\n❌ Reset failed: " . $e->getMessage() . "\n";
    exit(1);
}

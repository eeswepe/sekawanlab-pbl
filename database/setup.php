#!/usr/bin/env php
<?php

/**
 * Database Setup Script
 * Run migration and seeder in one command
 * Usage: php database/setup.php
 */

echo "╔═══════════════════════════════════════════╗\n";
echo "║   SEKAWAN Lab Database Setup Script      ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

echo "This script will:\n";
echo "1. Drop all existing tables\n";
echo "2. Create fresh database structure\n";
echo "3. Seed data to all tables\n\n";

echo "⚠️  WARNING: This will DELETE all existing data!\n\n";
echo "Do you want to continue? (yes/no): ";

$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
fclose($handle);

if (strtolower($line) !== 'yes') {
    echo "\n❌ Setup cancelled.\n";
    exit(0);
}

echo "\n";

// Run migration
echo "🔧 Running migration...\n";
echo "==========================================\n";
$migrationOutput = [];
$migrationReturn = 0;
exec('php ' . __DIR__ . '/migrate.php 2>&1', $migrationOutput, $migrationReturn);

foreach ($migrationOutput as $line) {
    echo $line . "\n";
}

if ($migrationReturn !== 0) {
    echo "\n❌ Migration failed. Stopping setup.\n";
    exit(1);
}

echo "\n";

// Run seeder
echo "🌱 Running seeder...\n";
echo "==========================================\n";
$seederOutput = [];
$seederReturn = 0;
exec('php ' . __DIR__ . '/seed.php 2>&1', $seederOutput, $seederReturn);

foreach ($seederOutput as $line) {
    echo $line . "\n";
}

if ($seederReturn !== 0) {
    echo "\n❌ Seeder failed.\n";
    exit(1);
}

echo "\n";
echo "╔═══════════════════════════════════════════╗\n";
echo "║       ✅ Setup Completed Successfully!    ║\n";
echo "╚═══════════════════════════════════════════╝\n";

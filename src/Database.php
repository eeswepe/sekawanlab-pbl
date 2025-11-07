<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    /**
     * Mendapatkan instance koneksi PDO khusus PostgreSQL.
     * @return PDO
     * @throws PDOException
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . "/../config/database.php";

            $host = $config["host"] ?? "localhost";
            $port = $config["port"] ?? 5432;
            $database = $config["database"] ?? "";
            $username = $config["username"] ?? "";
            $password = $config["password"] ?? "";
            $charset = $config["charset"] ?? null; // mis. 'UTF8' atau 'utf8'
            $sslmode = $config["sslmode"] ?? "prefer";

            $dsn = "pgsql:host={$host};port={$port};dbname={$database};sslmode={$sslmode}";

            try {
                self::$pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                if ($charset) {
                    self::$pdo->exec("SET client_encoding TO '{$charset}'");
                }
            } catch (PDOException $e) {
                throw new PDOException(
                    "Koneksi database gagal: " . $e->getMessage(),
                );
            }
        }

        return self::$pdo;
    }

    public static function query(string $sql, array $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}

<?php

namespace Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * [ Singleton ]
 *
 * @author Moises Pontes <moises@devpontes.com>
 * @package Core
 */
class Connect
{
    private const OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE               => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '-03:00'"
    ];

    /** @var PDO|null */
    private static ?PDO $conn = null;

    /**
     * Método de Conexão com o Banco de Dados
     *
     * @return PDO
     * @throws PDOException
     */
    public static function getConn(): PDO
    {
        if (self::$conn === null) {
            $host = $_ENV['DB_HOST'] ?? null;
            $name = $_ENV['DB_NAME'] ?? null;
            $user = $_ENV['DB_USER'] ?? null;
            $pass = $_ENV['DB_PASS'] ?? null;
            $port = $_ENV['DB_PORT'] ?? null;

            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);

            if (!$host || !$name || !$user) {
                throw new RuntimeException('Database credentials not configured');
            }

            try {
                self::$conn = new PDO($dsn, $user, $pass, self::OPTIONS);
            } catch (PDOException $ex) {
                // loggar erro mais tarde
                die('Error connecting to the database');
            }
        }

        return self::$conn;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new RuntimeException('Deserialization is not permitted');
    }
}

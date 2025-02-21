<?php

class Db
{
    public const DSN = 'mysql:host=localhost;dbname=coubooks';
    public const  USERNAME = 'root';
    public const PASSWORD = 'root';

    private static ?Db $instance = null;
    private ?PDO $connection = null;

    private function __construct() {
        try {
            $this->connection = new PDO(self::DSN, self::USERNAME, self::PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}
?>
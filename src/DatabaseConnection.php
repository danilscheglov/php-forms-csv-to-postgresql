<?php

class DatabaseConnection
{
    private PDO $pdo;
    private string $host;
    private int $port;
    private string $dbname;
    private string $user;
    private string $password;

    public function __construct()
    {
        $this->host = (string) getenv('DB_HOST');
        $this->port = (int) getenv('DB_PORT');
        $this->dbname = (string) getenv('DB_NAME');
        $this->user = (string) getenv('DB_USER');
        $this->password = (string) getenv('DB_PASSWORD');

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}

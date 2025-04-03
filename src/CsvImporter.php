<?php

class CsvImporter
{
    private PDO $pdo;
    private string $csvFile;

    public function __construct(PDO $pdo, string $csvFile = 'data/cars.csv')
    {
        $this->pdo = $pdo;
        $this->csvFile = $csvFile;
    }

    public function import(): void
    {
        $this->createTable();
        $this->truncateTable();
        $this->importData();
    }

    private function createTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS cars (
                id SERIAL PRIMARY KEY,
                brand VARCHAR(50) NOT NULL,
                model VARCHAR(50) NOT NULL,
                year INTEGER NOT NULL,
                color VARCHAR(30) NOT NULL
            )
        ");
    }

    private function truncateTable(): void
    {
        $this->pdo->exec("TRUNCATE TABLE cars RESTART IDENTITY");
    }

    private function importData(): void
    {
        if (!file_exists($this->csvFile)) {
            throw new RuntimeException("CSV file not found: " . $this->csvFile);
        }

        $file = fopen($this->csvFile, 'r');
        try {
            fgetcsv($file);

            $stmt = $this->pdo->prepare("
                INSERT INTO cars (brand, model, year, color) 
                VALUES (?, ?, ?, ?)
            ");

            while (($row = fgetcsv($file))) {
                $stmt->execute([
                    $row[0] ?? '',
                    $row[1] ?? '',
                    (int) ($row[2] ?? 0),
                    $row[3] ?? '',
                ]);
            }
        } finally {
            fclose($file);
        }
    }
}

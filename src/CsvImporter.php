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
        try {
            $this->pdo->exec("
                CREATE TABLE IF NOT EXISTS cars (
                    id SERIAL PRIMARY KEY,
                    brand VARCHAR(50) NOT NULL,
                    model VARCHAR(50) NOT NULL,
                    year INTEGER NOT NULL,
                    color VARCHAR(30) NOT NULL
                )
            ");

            $this->pdo->exec("TRUNCATE TABLE cars RESTART IDENTITY");

            if (file_exists($this->csvFile)) {
                $file = fopen($this->csvFile, 'r');
                fgetcsv($file);
                while (($row = fgetcsv($file)) !== false) {
                    $stmt = $this->pdo->prepare("INSERT INTO cars (brand, model, year, color) VALUES (?, ?, ?, ?)");
                    $stmt->execute([
                        $row[0],
                        $row[1],
                        (int) $row[2],
                        $row[3],
                    ]);
                }
                fclose($file);
            } else {
                throw new RuntimeException("Файл CSV не найден: " . $this->csvFile);
            }
        } catch (PDOException $e) {
            throw new RuntimeException("Ошибка импорта CSV: " . $e->getMessage());
        }
    }
}

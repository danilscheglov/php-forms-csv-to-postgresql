<?php

class TableDisplay
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function display(): void
    {
        try {
            $cars = $this->pdo->query("SELECT * FROM cars");
            $this->renderTemplate('table.php', ['cars' => $cars]);
        } catch (PDOException $e) {
            throw new RuntimeException("Ошибка вывода таблицы: " . $e->getMessage());
        }
    }

    private function renderTemplate(string $templatePath, array $data): void
    {
        $fullPath = __DIR__ . '/templates/' . $templatePath;

        if (!file_exists($fullPath)) {
            throw new RuntimeException("Шаблон $templatePath не найден по пути: $fullPath");
        }

        extract($data);

        require $fullPath;
    }
}

<?php

require_once 'DatabaseConnection.php';
require_once 'CsvImporter.php';
require_once 'TableDisplay.php';

try {
    $db = new DatabaseConnection();
    $pdo = $db->getPdo();

    $importer = new CsvImporter($pdo);
    $importer->import();

    $display = new TableDisplay($pdo);
    $display->display();
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

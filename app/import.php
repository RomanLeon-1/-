<?php
require 'db.php'; 

$file = fopen("orders.csv", "r"); 

if (!$file) {
    die("Не удалось открыть файл orders.csv.");
}

fgetcsv($file);

while (($data = fgetcsv($file, 1000, ",")) !== false) {
    if (count($data) < 6) {
        echo "Некорректная строка в CSV: " . implode(", ", $data) . "<br>";
        continue;
    }

    $waiter = trim($data[0], '"'); 
    $chef = trim($data[1], '"');  
    $table = (int)$data[2];       
    $dishes = trim($data[3], '"'); 
    $quantities = trim($data[4], '"'); 
    $comments = trim($data[5], '"');

    echo "Обработка строки: $waiter, $chef, $table, $dishes, $quantities, $comments<br>";

    $stmt = $pdo->prepare("INSERT INTO orders (waiter, chef, table_number, dishes, quantities, comments) VALUES (?, ?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$waiter, $chef, $table, $dishes, $quantities, $comments]);
        echo "Данные успешно добавлены в базу данных.<br>";
    } catch (PDOException $e) {
        echo "Ошибка при добавлении данных: " . $e->getMessage() . "<br>";
    }
}

fclose($file);

echo "Импорт завершён.";
?>
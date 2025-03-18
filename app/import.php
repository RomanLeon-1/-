<?php
require 'db.php'; // Подключение к базе данных

$file = fopen("orders.csv", "r"); // Открываем CSV-файл для чтения

if (!$file) {
    die("Не удалось открыть файл orders.csv.");
}

// Пропускаем заголовок CSV-файла (первую строку)
fgetcsv($file);

// Читаем данные из CSV и вставляем их в базу данных
while (($data = fgetcsv($file, 1000, ",")) !== false) {
    // Проверяем, что в строке 6 значений
    if (count($data) < 6) {
        echo "Некорректная строка в CSV: " . implode(", ", $data) . "<br>";
        continue;
    }

    // Обрабатываем данные
    $waiter = trim($data[0], '"'); // Убираем кавычки
    $chef = trim($data[1], '"');   // Убираем кавычки
    $table = (int)$data[2];        // Преобразуем в число
    $dishes = trim($data[3], '"'); // Убираем кавычки
    $quantities = trim($data[4], '"'); // Убираем кавычки
    $comments = trim($data[5], '"'); // Убираем кавычки

    echo "Обработка строки: $waiter, $chef, $table, $dishes, $quantities, $comments<br>";

    // Подготавливаем SQL-запрос
    $stmt = $pdo->prepare("INSERT INTO orders (waiter, chef, table_number, dishes, quantities, comments) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Выполняем запрос с данными из CSV
    try {
        $stmt->execute([$waiter, $chef, $table, $dishes, $quantities, $comments]);
        echo "Данные успешно добавлены в базу данных.<br>";
    } catch (PDOException $e) {
        echo "Ошибка при добавлении данных: " . $e->getMessage() . "<br>";
    }
}

fclose($file); // Закрываем файл

echo "Импорт завершён.";
?>
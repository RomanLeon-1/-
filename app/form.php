<?php
require 'db.php'; // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waiter = trim($_POST['waiter'] ?? '');
    $chef = trim($_POST['chef'] ?? '');
    $table = trim($_POST['table'] ?? '');
    $dishes = $_POST['dish'] ?? [];
    $quantities = trim($_POST['quantity'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    $errors = [];

    $data = json_decode(file_get_contents('data.json'), true);
    $validWaiters = $data['validWaiters'];
    $validChefs = $data['validChefs'];

    if (!in_array($waiter, $validWaiters)) {
        $errors[] = "Выберите корректного официанта.";
    }

    if (!in_array($chef, $validChefs)) {
        $errors[] = "Выберите корректного повара.";
    }

    if (!ctype_digit($table) || (int)$table <= 0) {
        $errors[] = "Номер столика должен быть положительным числом.";
    }

    $validDishes = ["Паста Карбонара", "Суп Том Ям", "Стейк Рибай", "Цезарь с курицей", "Суши сет", "Пицца Маргарита"];
    if (empty($dishes)) {
        $errors[] = "Выберите хотя бы одно блюдо.";
    } elseif (array_diff($dishes, $validDishes)) {
        $errors[] = "Выбрано некорректное блюдо.";
    }

    $quantityArray = array_map('trim', explode(',', $quantities));
    if (!empty($quantities) && (!array_filter($quantityArray, 'ctype_digit') || count($quantityArray) !== count($dishes))) {
        $errors[] = "Количество порций должно содержать только числа и соответствовать числу выбранных блюд.";
    }

    $forbiddenPatterns = [
        '/<[^>]*>/',
        '/\{.*?\}/',
        '/javascript:/i',
        '/(on[a-z]+\s*=)/i',
        '/style\s*=\s*/i'
    ];

    foreach ($forbiddenPatterns as $pattern) {
        if (preg_match($pattern, $comments)) {
            $errors[] = "Комментарий содержит запрещенные символы.";
            break;
        }
    }

    if (strlen($comments) > 200) {
        $errors[] = "Комментарий не должен превышать 200 символов.";
    }

    if (!empty($errors)) {
        echo implode("<br>", $errors);
    } else {
        // Сохраняем данные в CSV
        $dishesString = implode('; ', $dishes);
        $csvFile = 'orders.csv';
        $dataRow = [$waiter, $chef, $table, $dishesString, $quantities, $comments];

        if (($file = fopen($csvFile, 'a'))) {
            fputcsv($file, $dataRow);
            fclose($file);
            echo 'Заказ успешно сохранён в CSV!<br>';
        } else {
            echo 'Ошибка при сохранении заказа в CSV!<br>';
        }

        // Сохраняем данные в базу данных
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (waiter, chef, table_number, dishes, quantities, comments) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$waiter, $chef, $table, $dishesString, $quantities, $comments]);
            echo 'Заказ успешно сохранён в базу данных!';
        } catch (PDOException $e) {
            echo 'Ошибка при сохранении заказа в базу данных: ' . $e->getMessage();
        }
    }
}
?>
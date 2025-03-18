<?php
require 'db.php'; 

try {
    $stmt = $pdo->query("SELECT id, waiter, chef, table_number, dishes, quantities, comments FROM orders");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список заказов</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Список заказов</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Официант</th>
                <th>Повар</th>
                <th>Столик</th>
                <th>Блюда</th>
                <th>Количество</th>
                <th>Комментарии</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['waiter']) ?></td>
                        <td><?= htmlspecialchars($order['chef']) ?></td>
                        <td><?= htmlspecialchars($order['table_number']) ?></td>
                        <td><?= htmlspecialchars($order['dishes']) ?></td>
                        <td><?= htmlspecialchars($order['quantities']) ?></td>
                        <td><?= htmlspecialchars($order['comments']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Заказов пока нет</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

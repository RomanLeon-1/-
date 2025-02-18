<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = trim($_POST['client'] ?? '');
    $table_number = trim($_POST['table_number'] ?? '');
    $waiter_name = trim($_POST['waiter'] ?? '');
    $menu_item = trim($_POST['menu_item'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $chef_name = trim($_POST['chef'] ?? '');
    $order_time = trim($_POST['order_time'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    $csvFile = 'orders.csv';
    $dataRow = [
        $client_name,
        $table_number,
        $waiter_name,
        $menu_item,
        $quantity,
        $price,
        $chef_name,
        $order_time,
        $comments
    ];}

    if (($file = fopen($csvFile, 'a'))) {
        fputcsv($file, $dataRow);
        fclose($file);
        $message = 'Заказ успешно сохранён';
    } else {
        $message = 'Ошибка при сохранении заказа';
    }
    echo $message

?>

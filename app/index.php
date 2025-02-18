<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ресторан - Заказ</title>
</head>
<body>
    <h1>Форма заказа в ресторане</h1>
    <form action="form.php" method="POST">
        <label for="client">Имя клиента</label>
        <input type="text" name="client" id="client">
        <br><br>

        <label for="table_number">Номер столика</label>
        <input type="number" name="table_number" id="table_number">
        <br><br>

        <label for="waiter">ФИО официанта</label>
        <input type="text" name="waiter" id="waiter">
        <br><br>

        <label for="menu_item">Выберите блюдо</label>
        <select name="menu_item" id="menu_item">
            <option value="Суп">Суп</option>
            <option value="Паста">Паста</option>
            <option value="Стейк">Стейк</option>
            <option value="Десерт">Десерт</option>
        </select>
        <br><br>

        <label for="quantity">Количество</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1">
        <br><br>

        <label for="price">Стоимость блюда</label>
        <input type="number" name="price" id="price">
        <br><br>

        <label for="chef">ФИО повара</label>
        <input type="text" name="chef" id="chef">
        <br><br>

        <label for="order_time">Время заказа</label>
        <input type="time" name="order_time" id="order_time">
        <br><br>

        <label for="comments">Дополнительные пожелания</label>
        <textarea name="comments" id="comments" rows="4"></textarea>
        <br><br>

        <input type="submit" value="Оформить заказ">
    </form>
</body>
</html>

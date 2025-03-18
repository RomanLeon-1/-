<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа в ресторане</title>
</head>
<body>
    <h1>Ресторан "Вкусное место"</h1>
    
    <form action="form.php" method="POST" onsubmit="validateForm(event)">
        <label for="waiter">Выберите официанта</label>
        <select name="waiter" id="waiter" required>
            <option value="Иванов Иван">Иванов Иван</option>
            <option value="Петров Петр">Петров Петр</option>
            <option value="Сидоров Сидор">Сидоров Сидор</option>
        </select>
        <br><br>

        <label for="chef">Выберите повара</label>
        <select name="chef" id="chef" required>
            <option value="Смирнов Алексей">Смирнов Алексей</option>
            <option value="Кузнецов Олег">Кузнецов Олег</option>
            <option value="Васильев Виктор">Васильев Виктор</option>
        </select>
        <br><br>

        <label for="table">Номер столика</label>
        <input type="number" name="table" id="table" min="1" required>
        <br><br>

        <label for="dish">Выберите блюда</label>
        <select name="dish[]" id="dish" multiple required>
            <option value="Паста Карбонара">Паста Карбонара</option>
            <option value="Суп Том Ям">Суп Том Ям</option>
            <option value="Стейк Рибай">Стейк Рибай</option>
            <option value="Цезарь с курицей">Цезарь с курицей</option>
            <option value="Суши сет">Суши сет</option>
            <option value="Пицца Маргарита">Пицца Маргарита</option>
        </select>
        <br><br>

        <label for="quantity">Количество порций (в порядке ввода блюд)</label>
        <input type="text" name="quantity" id="quantity" placeholder="Пример: 1, 2, 1" required>
        <br><br>

        <label for="comments">Дополнительные пожелания</label>
        <textarea name="comments" id="comments" rows="3" placeholder="Например, без лука или острее"></textarea>
        <br><br>

        <input type="submit" value="Оформить заказ">
    </form>

    <script>
        function validateForm(event) {
            let waiter = document.getElementById("waiter").value;
            let chef = document.getElementById("chef").value;
            let table = document.getElementById("table").value;
            let dish = Array.from(document.getElementById("dish").selectedOptions).map(opt => opt.value);
            let quantity = document.getElementById("quantity").value;
            let comments = document.getElementById("comments").value;

            let errors = [];

            let validWaiters = ["Иванов Иван", "Петров Петр", "Сидоров Сидор"];
            let validChefs = ["Смирнов Алексей", "Кузнецов Олег", "Васильев Виктор"];
            let validDishes = ["Паста Карбонара", "Суп Том Ям", "Стейк Рибай", "Цезарь с курицей", "Суши сет", "Пицца Маргарита"];

            if (!validWaiters.includes(waiter)) {
                errors.push("Выберите корректного официанта.");
            }

            if (!validChefs.includes(chef)) {
                errors.push("Выберите корректного повара.");
            }

            if (dish.length === 0) {
                errors.push("Выберите хотя бы одно блюдо.");
            } else if (!dish.every(d => validDishes.includes(d))) {
                errors.push("Выбрано некорректное блюдо.");
            }

            if (!/^\d+$/.test(table) || parseInt(table) <= 0) {
                errors.push("Номер столика должен быть положительным числом.");
            }

            let quantityArray = quantity.split(",").map(q => q.trim());
            if (quantity && (!quantityArray.every(q => /^\d+$/.test(q)))) {
                errors.push("Количество порций должно содержать только числа.");
            }

            let forbiddenPatterns = [
                /<[^>]*>/,       
                /\{.*?\}/,          
                /javascript:/i,
                /(on[a-z]+\s*=)/i,  
                /style\s*=\s*/i    
            ];

            for (let pattern of forbiddenPatterns) {
                if (pattern.test(comments)) {
                    errors.push("Комментарий содержит запрещенные символы.");
                    break;
                }
            }

            if (comments.length > 200) {
                errors.push("Комментарий не должен превышать 200 символов.");
            }

            if (errors.length > 0) {
                event.preventDefault();
                alert(errors.join("\n"));
            }
        }
    </script>
</body>
</html>

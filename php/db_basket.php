<?php
// Подключение к базе данных MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_warrior";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос на извлечение почты пользователей
$sql = "SELECT email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод данных каждой строки
    while($row = $result->fetch_assoc()) {
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "0 результатов";
}

// Закрытие подключения
$conn->close();
?>

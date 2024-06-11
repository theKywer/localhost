<?php
// Подключение к базе данных MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_warrior";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных из формы
if(isset($_POST['first'], $_POST['email'], $_POST['password'], $_POST['repassword'])) {
    $username = $_POST['first'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Проверка на совпадение паролей
    if ($password != $repassword) {
        die("Пароли не совпадают");
    }

    // Хеширование пароля (рекомендуется)
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Подготовленный запрос для вставки данных в базу данных
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hashed);

    if ($stmt->execute()) {
        echo "Регистрация успешно завершена";
    } else {
        echo "Ошибка при регистрации: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Необходимо заполнить все поля формы.";
}

$conn->close();
?>

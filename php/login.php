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
if(isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username']; // Заменяем $first на $username
    $password = $_POST['password'];

    // Подготовленный запрос для выбора данных из базы данных
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); // Заменяем first на username
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Проверка пароля
            if (password_verify($password, $user['password'])) {
                echo "Вы успешно вошли!";
            } else {
                echo "Неверный логин или пароль.";
            }
        } else {
            echo "Пользователь с таким именем не найден.";
        }

        $stmt->close();
    } else {
        echo "Ошибка подготовки запроса.";
    }
} else {
    echo "Необходимо заполнить все поля формы.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация/Авторизация</title>
</head>
<body>
<?php
//запускаем сессию
session_start(['cookie_secure' => true,'cookie_httponly' => true]);

// Подключаем файл конфигурации
require_once('config.php');

// Проверяем, авторизован ли пользователь
if(isset($_SESSION['user_id']))
{
    // Если да, выводим приветствие и кнопку выхода (логаута)
    echo "Привет, ".$_SESSION['user_name']."!<br>";
    echo '<a href="logout.php">Выход</a>';
}
else
{
    // Если нет, выводим форму для регистрации
    echo '<h2>Регистрация</h2>';
    echo '<form action="register.php" method="post">';
    echo 'Имя: <input type="text" name="name"><br>';
    echo '<input type="submit" value="Зарегистрироваться">';
    echo '</form>';
    echo '<h2>Авторизация</h2>';
    echo '<form action="login.php" method="post">';
    echo 'Ключ: <input type="text" name="key"><br>';
    echo '<input type="submit" value="Войти">';
    echo '</form>';
    // Добавляем кнопку для авторизации через телеграм
    echo '<h2>Авторизация через Телеграм</h2>';
    echo '<a href="https://telegram.me/'.NAME_BOT.'?start=auth">Войти через Телеграм</a>';
}
?>
</body>
</html>
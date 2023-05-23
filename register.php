<?php
session_start(['cookie_secure' => true,'cookie_httponly' => true]);
// Проверяем, если уже авторизован, направляем на главную
if(isset($_SESSION['user_id']))
{
    header('location: index.php');
    exit;
}
// Подключаемся к базе данных
require_once('mysql.php');

if(!isset($_POST['name'])){
    echo 'Не задано имя';
    exit;
}
// Получаем имя из формы регистрации
$name = $db->real_escape_string($_POST['name']);

// Генерируем ключ для авторизации
$keyAuth32 = bin2hex(random_bytes(32));

// Выполняем запрос на добавление нового пользователя в базу данных
$query = $db->query("INSERT INTO `users` (`name`, `auth_key`) VALUES ('$name', '".hash('sha256',$keyAuth32)."')");

// Записываем данные пользователя в сессию
$_SESSION['user_id'] = $db->insert_id;
$_SESSION['user_name'] = $name;

// Показываем ключ авторизации
echo "Ваш ключ для авторизации ".$keyAuth32;
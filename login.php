<?php
/**
 * Авторизация участника по ключу
 */
session_start(['cookie_secure' => true,'cookie_httponly' => true]);

// Проверяем, если уже авторизован, направляем на главную
if(isset($_SESSION['user_id']))
{
    header('location: index.php');
    exit;
}
// Подключаемся к базе данных
require_once('mysql.php');
// Получаем ключ из формы авторизации и проверяем его
if(preg_match("/^[a-f0-9]{64}$/is",$_POST['key']))
{
    // Выполняем запрос на поиск пользователя с таким ключом в базе данных
    $result = $db->query("SELECT * FROM `users` WHERE `auth_key` = '".hash('sha256',$_POST['key'])."'");
    if($result->num_rows == 1)
    {
        // Если пользователь найден, записываем данные в сессию
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        // Перенаправляем пользователя на главную страницу
        header('location: index.php');
        exit;
    }
}
// Если пользователь не найден, выводим сообщение об ошибке
echo "Неверный ключ ".htmlspecialchars($_POST['key'], ENT_QUOTES, 'UTF-8');
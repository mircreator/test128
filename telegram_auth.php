<?php
session_start(['cookie_secure' => true,'cookie_httponly' => true]);
// Подключаемся к базе данных
require_once('mysql.php');
// Получаем ключ авторизации через ссылку из бота
if(preg_match("/^[a-f0-9]{64}$/is",$_GET['auth']))
{
    // Выполняем запрос на поиск пользователя с таким ключом в базе данных
    $result = $db->query("SELECT * FROM `users` WHERE `auth_tg` = '".hash('sha256',$_GET['auth'])."'");
    if($result->num_rows == 1)
    {
        // Если пользователь найден, записываем данные в сессию
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        // Удаляем временный ключ авторизации через телеграм
        $db->query("UPDATE `users` SET `auth_tg` = '' WHERE `id` = '".$user['id']."'");
        // Перенаправляем пользователя на главную страницу
        header('location: index.php');
        exit;
    }
}
// Если пользователь не найден по ключу
echo "Неверный ключ ".htmlspecialchars($_GET['auth'], ENT_QUOTES, 'UTF-8');

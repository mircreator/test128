<?php
session_start(['cookie_secure' => true,'cookie_httponly' => true]);

// Подключаемся к базе данных
require_once('mysql.php');

// Подключаем файл конфигурации
require_once('config.php');

// Входные данные из бота
$input = json_decode(file_get_contents('php://input'), true);

// Пользовательские данные
$chat_id = (int) $input['message']['chat']['id'];
$name = $db->real_escape_string($input['message']['from']['last_name'].' '.$input['message']['from']['first_name']);
$text = $input['message']['text'];
$keyAuth32 = bin2hex(random_bytes(32));

// Если дана команда авторизации
if($text == 'auth'){
    // Ищем участника по ID телеграма
    $result = $db->query("SELECT * FROM `users` WHERE `id_tg` = '".$chat_id."'");
    if($result->num_rows == 1)
    {
        //Если участник такой уже есть, записываем ключ к нему
        $db->query("UPDATE `users` SET `auth_tg` = '$keyAuth32' WHERE `id_tg` = '".$chat_id."'");
    }
    else
    {
        //Если участник не найден, создаем
        $db->query("INSERT INTO `users` (`id_tg`,`name`,`auth_tg`) VALUES ('$chat_id','$name','".hash('sha256',$keyAuth32)."')");
    }
    $urlAuth = "http://test128/telegram_login.php?auth=".$keyAuth32;
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => "https://api.telegram.org/bot".API_BOT."/sendMessage?chat_id=$chat_id&text=" . urlencode("Секретная ссылка для авторизации на сайте $urlAuth"),
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
}
exit;
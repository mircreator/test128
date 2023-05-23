<?php
/**
 * Подкючение к базе данных
 */
const DB_SERVER = 'localhost';// сервер базы данных
const DB_USERNAME = 'root';// имя пользователя базы данных
const DB_PASSWORD = '';// пароль пользователя базы данных
const DB_NAME = 'users';// имя базы данных

// Соединяемся с базой
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// В случае неудачного соединения показываем ошибку
if ($db->connect_error)
{
    die('Ошибка соединения (' . $db->connect_errno . ') ' . $db->connect_error);
}
<?php
session_start(['cookie_secure' => true,'cookie_httponly' => true]);

// Удаляем данные пользователя из сессии
session_unset();

// Перенаправляем пользователя на главную страницу
header('location: index.php');
exit;

<?php
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

//подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//разлогинивание
logout();

//Перенаправление на главную
header('Location: index.php');
?>
<?php
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

//подключение к БД
$link = startup();

//разлогинивание
logout();

//Перенаправление на главную
header('Location: index.php');
?>
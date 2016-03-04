<?php
//error_reporting(E_ERROR);

require_once('../functions/database.php');
require_once('../functions/functions.php');

//подключение к БД
$link = startup();

//разлогинивание
logout();

//Перенаправление на главную
header('Location: ../index.php');
?>
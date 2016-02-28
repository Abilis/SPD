<?php
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

//подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//Определение текущего пользователя
$user = getCurrentUser($link);

logout();

header('Location: index.php');
?>
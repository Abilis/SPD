<?php
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь находиться в панели администратор
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

if (!$canDoViewAdminPanel) {
    header('Location: index.php');
    die('не положено!');
}






//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-admin.php');
include_once('views/v-footer.php');
?>
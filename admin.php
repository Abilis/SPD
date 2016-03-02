<?php
//error_reporting(E_ERROR);
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь находиться в панели администратор
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

//Определяем, может ли пользователь делать импорт в БД файлов .cvs
$canDoImportInDb = canDo($link, $user, 'IMPORT_IN_DB');

if (!$canDoViewAdminPanel) {
    header('Location: index.php');
    die('не положено!');
}

//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);

//Запрашиваем залогиненных пользователей
$whoUsersOnline = getWhoIsOnline($link);






//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-admin.php');
include_once('views/v-footer.php');
?>
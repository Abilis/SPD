<?php
error_reporting(E_ERROR);
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь находиться в панели администратор
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

if (!$canDoViewAdminPanel) {
    header('Location: index.php');
    die('не положено!');
}

//Определяем, может ли пользователь добавлять записи
$canDoAdd = canDo($link, $user, 'ADD_ENTRY');

//получаем логи из БД для постраничной навигации
$logs_arr = get_logs_num_start($link);

//Разбираем полученный массив. Подробнее в functions.php
$logs = $logs_arr[0];
$page = $logs_arr[1]; //текущая страница
$total = $logs_arr[2]; //всего страниц
$num_rows = $logs_arr[3]; //количество логов на странице


//Форматирование вытащенных записей логов в удобный вид
$format_old_log = format_log($logs, 'entry_old_log', 10);
$format_new_log = format_new_log($logs, 'entry_new_log', 10);

//Создаем массив названий
$log_name = createLogName();

//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-all-logs.php');

//подключаем нижнее меню навигации
$current_page = 'all_logs.php';
include_once('menu_navigation.php');

include_once('views/v-footer.php');
?>
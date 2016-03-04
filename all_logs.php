<?php
error_reporting(E_ERROR);
require_once('functions/database.php');
require_once('functions/functions.php');
require_once('functions/access.php');

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

//Достаем общее количество логов
$numLogs = getNumLogs($link);

//Форматирование вытащенных записей логов в удобный вид
$format_old_log = format_log($logs, 'entry_old_log', 50);
$format_new_log = format_new_log($logs, 'entry_new_log', 50);

//Создаем массив названий
$log_name = createLogName();


//обработка $_POST-запроса по очистке логов
if ($_POST['deleteOldLogs']) {
    deleteOldLogs($link, $user);
    header('Location: all_logs.php');
    die();
    
}


//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-all-logs.php');

//подключаем нижнее меню навигации
$current_page = 'all_logs.php';
include_once('ss/menu_navigation.php');

include_once('views/v-footer.php');
?>
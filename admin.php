<?php
error_reporting(E_ERROR);
require_once('functions/database.php');
require_once('functions/functions.php');
require_once('functions/access.php');

//подключение к БД
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

//Определяем, может ли пользователь делать импорт в БД файлов .cvs
$canDoImportInDb = canDo($link, $user, 'IMPORT_IN_DB');

//Определяем, может ли пользователь управлять пользователями (расширенный вариант)
$canDoSuperusersControl = canDo($link, $user, 'SUPERUSERS_CONTROL');

//Обработка правки сообщения дня
if ($_GET['action'] == 'edit') {
    
    //проверка, есть ли права на правку сообщение дня
    $canDoEditMotd = canDo($link, $user, 'EDIT_MOTD');
        if (!$canDoEditMotd) {
            header('Location: admin.php');
            die();
        }
        else {

            //Вытаскивание сообщения дня
            $motd = get_motd($link);

            //Разбираем массив в переменные
            $text = $motd['text'];
            $autor = $motd['autor'];
            $dt_modt = $motd['dt_motd'];

            //Выводим в шаблоны
            include_once('views/v-header.php');
            include_once('views/v-menu.php');
            include_once('views/v-motd.php');
            include_once('views/v-footer.php');
            die();
        }
}

//обработка формы генерации сети
if ($_POST['markAddress'] && $_POST['network'] && $_POST['broadcast'] && $_POST['vlan'] && $_POST['termination']) {
    
    if (networkGeneration($link, $user, $_POST['markAddress'], $_POST['network'], $_POST['broadcast'], $_POST['vlan'],     $_POST['termination'])) {
        header('Location: admin.php');
        die();
    }
    
    
}



//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);

//Запрашиваем залогиненных пользователей
$whoUsersOnline_arr = getWhoIsOnline($link);

$whoUsersOnline = $whoUsersOnline_arr[0];
$numOnlineUsers = $whoUsersOnline_arr[1];

//Вытаскиваем логи из БД
$logs = getLogs($link, logs);


//Форматирование вытащенных записей логов в удобный вид
$format_old_log = format_log($logs, 'entry_old_log', 10);
$format_new_log = format_new_log($logs, 'entry_new_log', 10);

//Создаем массив названий
$log_name = createLogName();

//Вытаскивание сообщения дня
$motd = get_motd($link);
    
//Получаем список пользователей
$users_arr = getUsers($link);

//Разбираем полученный массив
$users = $users_arr[0];
$numUsers = $users_arr[1];

//Достаем общее количество логов
$numLogs = getNumLogs($link);

//Вытаскиваем логи действий из БД
$logsAction = getLogs($link, logs_action);

//Узнаем количество логов действий:
$numLogsAction = count($logsAction);

//вычисляем количество отображаемых логов действий в админке

if($numLogsAction > 10) {
    $numLogsActionInAdminPanel = 10;
}
else {
    $numLogsActionInAdminPanel = $numLogsAction;
}



//Устанавливаем значение радиоточки по умолчанию
$checkedAccessUser = 'checked';

//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-admin.php');
include_once('views/v-footer.php');
?>
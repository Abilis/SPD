<?php
 
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь редактировать, удалять записи и видеть панель администратора
$canDoEdit = canDo($link, $user, 'EDIT_ENTRY');
$canDoDelete = canDo($link, $user, 'DELETE_ENTRY');
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);



//Вытаскиваем все записи из БД
$entries = get_entryes_all($link);

    
//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-all_entries.php');

include_once('views/v-footer.php');

?>
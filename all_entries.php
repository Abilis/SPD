<?php
 
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//Определение текущего пользователя
$user = getCurrentUser($link);

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
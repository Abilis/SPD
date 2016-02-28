<?php
 
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);

//Вытаскиваем записи из БД для постраничной навигации
$entries_arr = get_entries_num_start($link);

//Разбираем полученный массив. Подробнее в functions.php
$entries = $entries_arr[0];
$page = $entries_arr[1]; //текущая страница
$total = $entries_arr[2]; //всего страниц
    
//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-login.php');
include_once('views/v-menu.php');
include_once('views/v-index.php');

//подключаем нижнее меню навигации
$current_page = 'index.php';
include_once('menu_navigation.php');

include_once('views/v-footer.php');

?>
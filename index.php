<?php
 
//error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

/*//вытаскиваем все записи из БД
$entries = get_entryes_all($link);*/

//Вытаскиваем записи из БД для постраничной навигации
$entries_arr = get_entries_num_start($link);

//Разрираем полученный массив. Подробнее в functions.php
$entries = $entries_arr[0];
$page = $entries_arr[1]; //текущая страница
$total = $entries_arr[2]; //всего страниц
    
//Выводим в шаблоны
include('views/v-header.php');
include('views/v-index.php');

//подключаем нижнее меню навигации
include('menu_navigation.php');

include('views/v-footer.php');

?>
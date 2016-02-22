<?php
require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

//Вытаскиваем записи из БД для постраничной навигации
$entries_arr = get_entries_num_start($link);

//Разбираем полученный массив. Подробнее в functions.php
$entries = $entries_arr[0];
$page = $entries_arr[1]; //текущая страница
$total = $entries_arr[2]; //всего страниц


//Если массив $_GET не пустой, то обработка правки и удаления статей.



//Иначе - отображение записей

//Выводим в шаблоны
include('views/v-header.php');
include('views/v-editor.php');

//подключаем нижнее меню навигации
include('menu_navigation.php');

include('views/v-footer.php');
?>
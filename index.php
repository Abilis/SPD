<?php

require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

//вытаскиваем все записи из БД
$entries = get_entryes_all($link);


//Выводим в шаблоны
include('views/v-header.php');
include('views/v-index.php');
include('views/v-footer.php');

?>
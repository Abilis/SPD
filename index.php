<?php

require_once('database.php');
require_once('functions.php');

// подключение к БД
startup();

//вытаскиваем все записи из БД
$entries = get_entryes_all();



?>
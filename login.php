<?php
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');

//подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//Определение текущего пользователя
$user = getCurrentUser($link);

//обработка отправки формы
if (!empty($_POST)) {
   
    if ( login($link, $_POST['login'], $_POST['password'], isset($_POST['remember'])) ) {
        header('Location: index.php');
        die();
    }
    
}

//Если форма пуста или залогиниться не удалось, выводим шаблоны залогинивания
include_once('views/v-header.php');
include_once('views/v-login.php');
include_once('views/v-footer.php');

?>
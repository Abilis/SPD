<?php
error_reporting(E_ERROR);
require_once('functions/database.php');
require_once('functions/functions.php');
require_once('functions/access.php');

//подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь добавлять записи и находиться в панели администратора
$canDoAdd = canDo($link, $user, 'ADD_ENTRY');
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

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
include_once('views/v-menu.php');
include_once('views/v-footer.php');

?>
<?php
require_once('../functions/database.php');
require_once('../functions/functions.php');
require_once('../functions/access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//проверка, есть ли права на правку сообщение дня
$canDoEditMotd = canDo($link, $user, 'EDIT_MOTD');

if (!$canDoEditMotd) {
    header('Location: ../index.php');
    die();
}

//Обработка отправки формы
if ($_POST['motd']) {
    
    if (updateMotd($link, $user, $_POST['motd'])) {
        header('Location: ../admin.php'); //в случае успеха - редирект в админку
        die();
    }
    
    //а в случае неуспеха - запомнить введенное сообщение дня
    $text = $_POST['motd'];
}

//Если же $_POST['motd'] пусто, то обнулить $text
$text = '';

//Определяем, может ли пользователь находиться в панели администратор
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

//Выводим в шаблоны
include_once('../views/v-header.php');
include_once('../views/v-menu.php');
include_once('../views/v-motd.php');
include_once('../views/v-footer.php');
?>
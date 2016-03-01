<?php
error_reporting(E_ERROR);

//Сценарий для обработки запросов к БД из форм поисков
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь редактировать и удалять записи
$canDoEdit = canDo($link, $user, 'EDIT_ENTRY');
$canDoDelete = canDo($link, $user, 'DELETE_ENTRY');

//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);


if (!empty($_POST['numOrder'])) {
    //Поиск записей по номеру договора
    $entries = get_entry_by_order($link, $_POST['numOrder']);    
}
else if (!empty($_POST['customer'])) {
    //Поиск записей по название клиента
    $entries = get_entry_by_customer($link, $_POST['customer']);    
}
else if (!empty($_POST['ip_address'])) {
    //Поиск записей по IP-адресу
    $entries = get_entry_by_ip($link, $_POST['ip_address']);    
}
else if (!empty($_POST['vlan_id'])) {
    //Поиск записей по номеру влан
    $entries = get_entries_by_vlan($link, $_POST['vlan_id']);    
}
else if (!empty($_POST['last_editor'])) {
    //Поиск записей по носледнему редактору
    $entries = get_entry_by_last_editor($link, $_POST['last_editor']);    
}
else {
   header('Location: index.php'); 
}



//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-index.php');



?>
<?php
//Сценарий для обработки запросов к БД из views/v-index.php
require_once('database.php');
require_once('functions.php');

// подключение к БД
$link = startup();

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
include('views/v-header.php');
include('views/v-index.php');
include('views/v-footer.php');

?>
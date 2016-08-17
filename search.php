<?php
error_reporting(E_ERROR);

//Сценарий для обработки запросов к БД из форм поисков
require_once('functions/database.php');
require_once('functions/functions.php');
require_once('functions/access.php');

// подключение к БД
$link = startup();



//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь редактировать, добавлять, удалять записи и видеть панель администратора
$canDoEdit = canDo($link, $user, 'EDIT_ENTRY');
$canDoAdd = canDo($link, $user, 'ADD_ENTRY');
$canDoDelete = canDo($link, $user, 'DELETE_ENTRY');
$canDoViewAdminPanel = canDo($link, $user, 'ADMIN_PANEL');

//вытаскиваем полное число записей из БД
//$numEntriesAll = getEntriesAll($link);

//работа с сессиями, чтобы отслеживать, какая кнопка была нажата в последний раз
if ((isset($_POST['sortedByVlan']) || isset($_POST['sortedByVlanAllEntries'])) && !isset($_POST['sortedByDateLastEdited'])) {
    $_SESSION['sortedByDateLastEdited'] = null;  //обнуляем запись в сессии, что идет сортировка по дате последней правки
} else if ((!isset($_POST['sortedByVlan']) && !isset($_POST['sortedByVlanAllEntries'])) && isset($_POST['sortedByDateLastEdited'])) {
    $_SESSION['sortedByVlan'] = null;  //обнуляем запись в сессии, что идет сортировка по влан
}


if (!empty($_POST['numOrder'])) {
    //Поиск записей по номеру договора
    $entries = get_entry_by_order($link, $_POST['numOrder']);
    $searchStringNumOrder = $_POST['numOrder'];
} else if (!empty($_POST['customer'])) {
    //Поиск записей по название клиента
    $entries = get_entries_by_customer($link, $_POST['customer']);
    $searchStringCustomer = $_POST['customer'];
} else if (!empty($_POST['ip_address'])) {
    //Поиск записей по IP-адресу
    $entries = get_entries_by_ip($link, $_POST['ip_address']);
    $searchStringIpAddress = $_POST['ip_address'];
} else if (!empty($_POST['vlan_id'])) {
    //Поиск записей по номеру влан
    $entries = get_entries_by_vlan($link, $_POST['vlan_id']);
    $searchStringVlanId = $_POST['vlan_id'];
} else if (!empty($_POST['last_editor'])) {
    //Поиск записей по носледнему редактору
    $entries = get_entries_by_last_editor($link, $_POST['last_editor']);
    $searchStringLastEditor = $_POST['last_editor'];
} else if (!empty($_POST['commentary'])) {
    //Поиск записей по носледнему редактору
    $entries = get_entries_by_commentary($link, $_POST['commentary']);
    $searchStringCommentary = $_POST['commentary'];
} else if (!empty($_POST['termPointForSearch'])) {
    //Поиск свободных IP-адресов, терминирующихся на определенной точке терминации    
    $entries = searchFreeAddresses($link, $_POST['termPointForSearch']);
    $searchStringTermPoint = $_POST['termPointForSearch'];    
} else if (isset($_POST['sortedByVlan']) || $_SESSION['sortedByVlan'] == 'mainPage') { //для index.php
    //Обработка нажатия кнопки сортировки по влан
    $entries_arr = sortedByVlan($link);
    $entries = $entries_arr[0];    
    $page = $entries_arr[1]; //текущая страница
    $total = $entries_arr[2]; //всего страниц    
} else if (isset($_POST['sortedByVlanAllEntries'])) { //для all_entries.php
    $_SESSION['sortedByDateLastEdited'] = null;  //обнуляем запись в сессии, что идет сортировка по дате последней правки
    $entries = sortedByVlanAllEntries($link);    
} else if (isset($_POST['sortedByDateLastEdited']) || $_SESSION['sortedByDateLastEdited'] == 'mainPage') { //сортировка по дате последней правки для index.php
    //Обработка нажатия кнопки сортировки по дате последней правки    
    $entries_arr = sortedByDateLastEdited($link);
    $entries = $entries_arr[0];    
    $page = $entries_arr[1]; //текущая страница
    $total = $entries_arr[2]; //всего страниц
}
else { //если ничего не подошло - кидаем на главную
   header('Location: ../index.php'); 
}


//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-index.php');
if ($_SESSION['sortedByVlan'] == 'mainPage' || $_SESSION['sortedByDateLastEdited'] == "mainPage") {   
    $current_page = 'search.php';
    include_once('ss/menu_navigation.php');
}
include_once('views/v-footer.php');
?>
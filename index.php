<?php
//error_reporting(E_ERROR);
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//очистка старых сессий
clearSessionsInDB($link);

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь редактировать и удалять записи
$canDoEdit = canDo($link, $user, 'EDIT_ENTRY');
$canDoDelete = canDo($link, $user, 'DELETE_ENTRY');

//вытаскиваем полное число записей из БД
$numEntriesAll = getEntriesAll($link);

//Вытаскиваем записи из БД для постраничной навигации
$entries_arr = get_entries_num_start($link);

//Разбираем полученный массив. Подробнее в functions.php
$entries = $entries_arr[0];
$page = $entries_arr[1]; //текущая страница
$total = $entries_arr[2]; //всего страниц


//Если массив $_GET не пустой, то обработка правки и удаления статей.
if (($_GET['action']) == 'edit') {
    //правка записи
    $entry = get_entry($link, $_GET['id_entry']); //вытаскиваем конкретную запись из БД
    
    //Разбираем массив в переменные
    $id_entry = $entry['id_entry'];
    $numOrder = $entry['numOrder'];
    $customer = $entry['customer'];
    $tarif = $entry['tarif'];
    $ip_address = $entry['ip_address'];
    $netmask = $entry['netmask'];
    $gateway = $entry['gateway'];
    $vlan_id = $entry['vlan_id'];
    $customer_port = $entry['customer_port'];
    $termination_point = $entry['termination_point'];
    $commentary = $entry['commentary'];
        
    //Выводим в шаблон
    include('views/v-header.php');
    include('views/v-edit.php');
    include('views/v-footer.php');
    die();
    
    
    
    
}
elseif (($_GET['action']) == 'delete') {
    if (delete_entry($link, $_GET['id_entry'])) {
        header('Location: index.php');
        die();
    }
}

//обработка отправки формы
elseif (!empty($_POST)) { //если массив не пустой
    if (entry_edit($link, $_POST['id_entry'], $_POST['numOrder'], $_POST['customer'],
                   $_POST['tarif'], $_POST['ip_address'], $_POST['netmask'], $_POST['gateway'],
                   $_POST['vlan_id'], $_POST['customer_port'], $_POST['termination_point'],
                   $_POST['commentary'])) { //update в базе. Если успешно - редирект на editor.php
        header('Location: index.php');
        die();
    }
    
    //сохраняем введенные в поля данные, если что-то пошло не так
    $numOrder = $_POST['numOrder'];
    $customer = $_POST['customer'];
    $tarif = $_POST['tarif'];
    $ip_address = $_POST['ip_address'];
    $netmask = $_POST['netmask'];
    $gateway = $_POST['gateway'];
    $vlan_id = $_POST['vlan_id'];
    $customer_port = $_POST['customer_port'];
    $termination_point = $_POST['termination_point'];
    $commentary = $_POST['commentary'];
}


//Иначе - отображение записей

//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-index.php');

//подключаем нижнее меню навигации
$current_page = 'index.php';
include_once('menu_navigation.php');

include_once('views/v-footer.php');
?>
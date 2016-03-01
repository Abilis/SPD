<?php
error_reporting(E_ERROR);

require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Если пользователь на залогинен - вывод сообщения об необходимости авторизации
if ($user == null) {
    
    //Выводим в шаблоны
    include_once('views/v-header.php');
    include_once('views/v-menu.php');
    include_once('views/v-add-error.php');
    include_once('views/v-footer.php');
        die();
}

//Определяем, может ли пользователь добавлять записи
$canDoAdd = canDo($link, $user, 'ADD_ENTRY');

if (!$canDoAdd) {
    
    //Выводим в шаблоны
    include_once('views/v-header.php');
    include_once('views/v-menu.php');
    include_once('views/v-add-error.php');
    include_once('views/v-footer.php');
    die();
}


//обработка отправки формы
if (!empty($_POST)) { //если массив не пустой
    if (entry_add($link, $user, $_POST['numOrder'], $_POST['customer'], $_POST['tarif'], $_POST['ip_address'],                         $_POST['netmask'], $_POST['gateway'], $_POST['vlan_id'], $_POST['customer_port'],                           $_POST['termination_point'], $_POST['commentary'])) { //запись в базу. Если успешно - редирект на главную
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
else {
    //если пустой - обнулить переменные
    $numOrder = "";
    $customer = "";
    $tarif = "";
    $ip_address = "";
    $netmask = "";
    $gateway = "";
    $vlan_id = "";
    $customer_port = "";
    $termination_point = "";
    $commentary = "";
}


//Выводим в шаблоны
include_once('views/v-header.php');
include_once('views/v-menu.php');
include_once('views/v-add.php');
include_once('views/v-footer.php');
?>
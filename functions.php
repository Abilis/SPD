<?php
//Вытаскиваем все записи из БД
function get_entryes_all($link) {
    
    //Запрос
    $query = "SELECT * FROM spd_table ORDER BY id_entry DESC";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Извлечение из БД
    $n = mysqli_num_rows($result);
    $entries = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $entries[] = $row;
    }
    
    return $entries;
}

//Вытаскиваем запись с соответствующим номером договора
function get_entry_by_order($link, $numOrder) {
    
    
    
}

//Вытаскиваем запись по названию клиента
function get_entry_by_customer($link, $customer) {
    
    
    
}

//Вытаскиваем записи с соответствующим тарифом
function get_entries_by_tarif($link, $tarif) {
    
    
    
}

//Вытаскиваем запись с соответствующим IP-адресом
function get_entry_by_ip($link, $ip_address) {
    
    
    
}

//Вытаскиваем записи с соответствующим вланом
function get_entries_by_vlan($link, $vlan_id) {
    
    
    
}

//Вытаскиваем записи с соответствующей точкой терминации
function get_entries_by_termination($link, $termination_point) {
    
    
    
}

//Поиск по автору
function get_entries_by_founder($link, $founder) {
    
    
    
}

//Поиск по последнему редактору
function get_entry_by_last_editor($link, $last_editor) {
    
    
    
}


?>
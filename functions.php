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

//Вытаскиваем из БД $num строк начиная с номера $start для постраничного вывода записей
function get_entries_num_start($link) {
    
    $num = 100; //число выводимых записей
    
    //Извлекаем из URL текущую страницу
    $page = (int)($_GET['page']);
    
    //Определяем общее число записей в БД
    $query = "SELECT COUNT(*) FROM spd_table";
    $result = mysqli_query($link, $query);
        
    if (!$result) {
        die(mysqli_error($link));
    }
    
    $n = mysqli_fetch_row($result);
    var_dump($n);
        
    
    //Находим общее число страниц   
    $total = (($n - 1) / $num) + 1;
 
    //Определяем начало сообщений для текущей страницы
    
    $page = intval($page);
    
    //Если значение $page меньше 1 или 0, переходим на первую страницу
    //А если слишком большое - на последнюю
    if (empty($page) or $page < 0) {
        $page = 1;
    }
    elseif ($page > $total) {
        $page = $total;
    }
    
    //Вычисляем начиная с какого номера следует выводить записи
    $start = $page * $num - $num;
    
    //Формируем запрос на выборку $num записей начиная с номера $start
    $query = "SELECT * FROM spd_table LIMIT $start, $num";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Разбираем полученный дескриптор в индексный массив
    while ($entries[] = mysqli_fetch_array($result));
    
    
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
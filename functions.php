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
    
    $m = mysqli_fetch_row($result);
    $n = (int)$m[0]; //количество записей в БД
            
    
    //Находим общее число страниц   
    $total = (int)(($n - 1) / $num) + 1;
     
    //Определяем начало сообщений для текущей страницы
    
    $page = intval($page);
    
    //Если значение $page меньше 1 или 0, переходим на первую страницу
    //А если слишком большое - на последнюю
    if (empty($page) || $page < 0) {
        $page = 1;
    }
    elseif ($page > $total) {
        $page = $total;
    }
    
    //Вычисляем начиная с какого номера следует выводить записи
    $start = $page * $num - $num;
    
    //Формируем запрос на выборку $num записей начиная с номера $start
    $query = "SELECT * FROM spd_table ORDER BY id_entry DESC LIMIT $start, $num";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Разбираем полученный дескриптор в индексный массив
    
    $num_rows = mysqli_num_rows($result); //число полученных строк
       
    $entries = array(); //создаем вспомогательный массив для записи результата выборки
    
    for ($i = 0; $i < $num_rows; $i++) {
        $entries[] = mysqli_fetch_array($result);
    }
     
    /*Поскольку для отрисовки навигации понадобятся переменные $page, $total и $entries,
    а передать наружу можно только одну переменную, придется собирать массив*/
    $entries_arr[0] = $entries;
    $entries_arr[1] = $page;
    $entries_arr[2] = $total;
    
    return $entries_arr;
}


//Вытаскиваем запись с соответствующим номером договора
function get_entry_by_order($link, $numOrder) {
    
    //подготовка и проверка
    $numOrder = trim($numOrder);
    $numOrder = (int)($numOrder); //приведение к числу

    if ($numOrder == '') {        
        header('Location: index.php');
        die();
    }
    
    //Запрос
    $query = "SELECT * FROM spd_table WHERE numOrder='$numOrder' ORDER BY id_entry DESC";
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

//Вытаскиваем запись по названию клиента
function get_entry_by_customer($link, $customer) {
    
    //подготовка и проверка
   $customer = trim($customer);
    
    if ($customer == '') {
        header('Location: index.php');
        die();
    }
    
    $customer = mysqli_real_escape_string($link, $customer);
    
    //Запрос
    $query = "SELECT * FROM spd_table WHERE customer LIKE '%$customer%' ORDER BY id_entry DESC";
    
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

//Вытаскиваем записи с соответствующим тарифом
function get_entries_by_tarif($link, $tarif) {
    
    
    
}

//Вытаскиваем запись с соответствующим IP-адресом
function get_entry_by_ip($link, $ip_address) {
    
    //подготовка и проверка
   $ip_address = trim($ip_address);
    
    if ($ip_address == '') {
        header('Location: index.php');
        die();
    }
    
    $customer = mysqli_real_escape_string($link, $ip_address);
    
    //Запрос
    $query = "SELECT * FROM spd_table WHERE ip_address LIKE '%$ip_address%' ORDER BY id_entry DESC";
    
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

//Вытаскиваем записи с соответствующим вланом
function get_entries_by_vlan($link, $vlan_id) {
    
    //подготовка и проверка
    $numOrder = trim($vlan_id);
    $numOrder = (int)($vlan_id); //приведение к числу

    if ($vlan_id == '') {        
        header('Location: index.php');
        die();
    }
    
    //Запрос
    $query = "SELECT * FROM spd_table WHERE vlan_id='$vlan_id' ORDER BY id_entry DESC";
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

//Вытаскиваем записи с соответствующей точкой терминации
function get_entries_by_termination($link, $termination_point) {
    
    
    
}

//Поиск по автору
function get_entries_by_founder($link, $founder) {
    
    
    
}

//Поиск по последнему редактору
function get_entry_by_last_editor($link, $last_editor) {
    
    //подготовка и проверка
   $last_editor = trim($last_editor);
    
    if ($last_editor == '') {
        header('Location: index.php');
        die();
    }
    
    $customer = mysqli_real_escape_string($link, $last_editor);
    
    //Запрос
    $query = "SELECT * FROM spd_table WHERE last_editor LIKE '%$last_editor%' ORDER BY id_entry DESC";
    
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


?>
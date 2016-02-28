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

function getEntriesAll($link) {
    
    $query = "SELECT COUNT(*) FROM spd_table";
    $result = mysqli_query($link, $query);
        
    if (!$result) {
        die(mysqli_error($link));
    }
    
    $m = mysqli_fetch_row($result);
    $n = (int)$m[0]; //количество записей в БД
    
    return $n;
    
}

function get_entry($link, $id_entry) {
    
    //Подготовка
    $id_entry = trim($id_entry);
    $id_entry = (int)($id_entry);
    
    if ($id_entry =='') {
        header('Location: editor.php');
        die();
    }
    
    //формируем запрос
    $sql = "SELECT * FROM spd_table WHERE id_entry='$id_entry'";
    
    //Выполняем запрос
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        die(mysqli_error());
    }
    
    //Собираем из дескриптора ассоциативный массив
    $entry = mysqli_fetch_assoc($result);    
    
    return $entry;
}

//Вытаскиваем из БД $num строк начиная с номера $start для постраничного вывода записей
function get_entries_num_start($link) {
    
    $num = 50; //число выводимых записей
    
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
    
    $ip_address = mysqli_real_escape_string($link, $ip_address);
    
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
    
    $last_editor = mysqli_real_escape_string($link, $last_editor);
    
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

function entry_add($link, $numOrder, $customer, $tarif, $ip_address, $netmask, $gateway, $vlan_id, $customer_port, $termination_point, $commentary) {
    
    /*обязательные аргументы: $customer, $ip_address, $vlan_id. Если они не переданы - запись в БД невозможа. Если что-то из остальных равно null, запись возможна */
    
    //подготовка
    $numOrder = trim($numOrder);
    $customer = trim($customer);
    $tarif = trim($tarif);
    $ip_address = trim($ip_address);
    $netmask = trim($netmask);
    $gateway = trim($gateway);
    $vlan_id = trim($vlan_id);
    $customer_port = trim($customer_port);
    $termination_point = trim($termination_point);
    $commentary = trim($commentary);
    
    //проверка обязательных параметров
    if (($customer == '') || ($ip_address == '') || ($vlan_id == '') ) {
        return false;
        
    }
    
    //экранирование html-тегов
    $numOrder = htmlspecialchars($numOrder);
    $customer = htmlspecialchars($customer);
    $tarif = htmlspecialchars($tarif);
    $ip_address = htmlspecialchars($ip_address);
    $netmask = htmlspecialchars($netmask);
    $gateway = htmlspecialchars($gateway);
    $vlan_id = htmlspecialchars($vlan_id);
    $customer_port = htmlspecialchars($customer_port);
    $termination_point = htmlspecialchars($termination_point);
    $commentary = htmlspecialchars($commentary);
    
    //установка текущей даты
    $dt_added = date('Y-m-j G:i:s');
    
    //дополнительные параметры: $subnet (subnet); $broadcast (broadcast); $founder (founder)
    
    //формируем запрос
    $sql = "INSERT INTO spd_table 
                                (numOrder, customer, tarif, ip_address,
                                netmask, gateway, vlan_id, customer_port,
                                termination_point, dt_added, commentary)
                                    VALUES 
                                        ('%d', '%s', '%s', '%s', '%s', '%s', '%d',
                                        '%s', '%s', '%s', '%s')";
    
    $query = sprintf($sql,
                    mysqli_real_escape_string($link, $numOrder),
                    mysqli_real_escape_string($link, $customer),
                    mysqli_real_escape_string($link, $tarif),
                    mysqli_real_escape_string($link, $ip_address),
                    mysqli_real_escape_string($link, $netmask),
                    mysqli_real_escape_string($link, $gateway),
                    mysqli_real_escape_string($link, $vlan_id),
                    mysqli_real_escape_string($link, $customer_port),
                    mysqli_real_escape_string($link, $termination_point),
                    mysqli_real_escape_string($link, $dt_added),
                    mysqli_real_escape_string($link, $commentary));
    
    //наконец-то его можно выполнить!
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die('Не получилось :(' . mysqli_error());
    }
        
    return true;
}

function delete_entry($link, $id_entry) {
    
    //формируем запрос
    $sql = "DELETE FROM spd_table WHERE id_entry ='%d'";
    
    $query = sprintf($sql,
                    mysqli_real_escape_string($link, $id_entry));
    
    //выполняем запрос
    $result = mysqli_query($link, $query);
    
    if (!result) {
        die('Не удалось удалить запись с id = ' . $id_entry . mysql_error());
    }
    
    //запись в лог действия. Пока нереализовано
    
    return true;
}

function entry_edit($link, $id_entry, $numOrder, $customer, $tarif, $ip_address, $netmask, $gateway, $vlan_id, $customer_port, $termination_point, $commentary) {
    
    /*обязательные аргументы: $id_entry, $customer, $ip_address, $vlan_id. Если они не переданы - запись в БД невозможа. Если что-то из остальных равно null, запись возможна */
    
    //подготовка
    $id_entry = trim($id_entry);
    $numOrder = trim($numOrder);
    $customer = trim($customer);
    $tarif = trim($tarif);
    $ip_address = trim($ip_address);
    $netmask = trim($netmask);
    $gateway = trim($gateway);
    $vlan_id = trim($vlan_id);
    $customer_port = trim($customer_port);
    $termination_point = trim($termination_point);
    $commentary = trim($commentary);
    
    //проверка обязательных параметров
    if (($id_entry =='') || ($customer == '') || ($ip_address == '') || ($vlan_id == '') ) {
        return false;
        
    }
    
    //экранирование html-тегов
    $numOrder = htmlspecialchars($numOrder);
    $customer = htmlspecialchars($customer);
    $tarif = htmlspecialchars($tarif);
    $ip_address = htmlspecialchars($ip_address);
    $netmask = htmlspecialchars($netmask);
    $gateway = htmlspecialchars($gateway);
    $vlan_id = htmlspecialchars($vlan_id);
    $customer_port = htmlspecialchars($customer_port);
    $termination_point = htmlspecialchars($termination_point);
    $commentary = htmlspecialchars($commentary);
    
    //установка текущей даты
    $dt_last_edited = date('Y-m-j G:i:s');
    
    //дополнительные параметры: $subnet (subnet); $broadcast (broadcast); $founder (founder)
    
    //формируем запрос
    $sql = "UPDATE spd_table SET
                                numOrder='%d', customer='%s', tarif='%s', ip_address='%s',
                                netmask='%s', gateway='%s', vlan_id='%d', customer_port='%s',
                                termination_point='%s', dt_last_edited='%s', commentary='%s'
                                WHERE id_entry='%d'";
    
    $query = sprintf($sql,
                    mysqli_real_escape_string($link, $numOrder),
                    mysqli_real_escape_string($link, $customer),
                    mysqli_real_escape_string($link, $tarif),
                    mysqli_real_escape_string($link, $ip_address),
                    mysqli_real_escape_string($link, $netmask),
                    mysqli_real_escape_string($link, $gateway),
                    mysqli_real_escape_string($link, $vlan_id),
                    mysqli_real_escape_string($link, $customer_port),
                    mysqli_real_escape_string($link, $termination_point),
                    mysqli_real_escape_string($link, $dt_last_edited),
                    mysqli_real_escape_string($link, $commentary),
                    mysqli_real_escape_string($link, $id_entry));
    
    //наконец-то его можно выполнить!
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die('Не получилось :(' . mysqli_error());
    }
        
    return true;
}

//функция получения имени залогиненного пользователя, если оно есть
/*function getCurrentUser($link, $id_user = null) {
    
     //Если id_user не указан, берем его по текущей сессии
    if ($id_user == null) {
        $id_user = getUid($link);
    }
    if ($id_user == null) {
        return null;
    }
    
    //Ищем в БД пользователя по id_user
    
    
    
    return $_SESSION['sid'];
}*/

//Получение текущего пользователя
/*function getUid($link) {
    
    //берем из текущей сессии
    $sid = getSid($link);
    
    if ($sid == null) {
        return null;
    }
    
    //Если же в $sid что-то есть, то делаем запрос в БД
        
    
    return $_SESSION['sid'];
}*/

/*function getSid($link) {
    
    //Ищем sid в сессии
    $sid = $_SESSION['sid'];
    
    //Если нашли, пробуем обновить last_time в БД. Заодно проверим,
    //есть ли там сессия
    
    if ($sid != null) {
        
        $time_last = date('Y.m.d G:i:s');
        $time_last = mysqli_real_escape_string($link, $time_last);
        
        //Формируем запрос
        $query = "UPDATE sessions SET `time_last`='$time_last' WHERE sid = '$sid'";
        
        //Выполняем запрос
        $result = mysqli_query($link, $query);
        
        if (!$result) {
            die(mysqli_error($link));
        }
        
        $affected_rows = mysqli_affected_rows($link);
        //Если была затронута 1 строка, значит, обновление прошло успешно.
        //Значит, в БД была запись о сессии
        
        
        //если $affected_rows == 0, это еще не значит, что апдейта не произошло. Поэтому нужна проверка
        if ($affected_rows == 0) {
            //пробуем сделать SELECT. Если запрос вернет затронутых строк 0, значит, записи сессии не было
            
            //формируем запрос
            
            $sid = mysqli_real_escape_string($link, $sid);
            $query = "SELECT * FROM sessions WHERE `sid`='$sid'";
            
            //выполняем запрос
                        
            $result = mysqli_query($link, $query);
            
            if (!$result) {
                die(mysqli_error($link));
            }
            
            //Собираем из дескриптора ассоциативный массив
            $entry = mysqli_fetch_assoc($result);
            $sid = $entry['sid'];
            
            if ($sid != null) {
                return $sid;
            }
            
        } //конец проверки по SELECT
        
    
    
    }
    //Раз мы дошли досюда, значит, в $_SESSION не было sid. Будем искать login и password в куках,
    //чтобы переподключиться
    if ($sid = null && !isset($_COOKEI['login'])) {
        
        $user = getByLogin($link, $_COOKIE['login']);
        
        if ($user != null && $user['password'] == $_COOKIE['password']) {
            $sid = open_session($link, $user['id_user']);
        }
    }   
    
    return $sid;
}*/

//функция разлогинивания
function logout() {
    setcookie('login', '', time() - 1);
    setcookie('password', '', time() - 1);
    unset($_COOKIE['login']);
    unset($_COOKIE['password']);
    unset($_SESSION['sid']);
    $sid = null;
    $uid = null;
}

//функция залогинивания
//return true - залогинивание успешно, return false - неуспешно
function login($link, $login, $password, $remember){
    
    //вытаскиваем пользователя из БД
    $user = getByLogin($link, $login); //database.php
    
    if ($user == null) {
        return false; //если не удалось найти пользователя с таким логином
    }
    
    $id_user = $user['id_user']; //из полученного ассоциативного массива
    
    //Проверяем пароль
    if ($user['password'] != md5($password)) {
        return false; //если пароль в БД не совпадает с введенным
    }
    
    //если было установлено "запомнить меня", вешаем куки на логин и пароль
    if ($remember) {
        $expire = time() + 3600 * 24 * 7;
        setcookie('login', $login, $expire);
        setcookie('password', md5($password), $expire);
    }
    
    //открываем сессию и запоминаем SID
    open_session($link, $id_user);
    
    
    return true;
}

//Открытие новой сессии. Результат SID
function open_session($link, $id_user) {
    
    //генерируем SID
    $sid = generateStr(15);
    
    //Вставляем SID в БД
    $now = date('Y.m.d G:i:s');
    $session = array();
    $session['id_user'] = $id_user;
    $session['sid'] = $sid;
    $session['time_start'] = $now;
    $session['time_last'] = $now;
    
    openSessionInDb($link, $session); //записываем сессию в БД. database.php
    
    //Регистрируем сессию в PHP-сессии
    $_SESSION['sid'] = $sid;
    
    return $sid;
    
}


//Генерация случайной последовательсности символов
function generateStr($length) {
    
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = iconv_strlen($chars) - 1;
    
    while (iconv_strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    
    return $code;
}


?>
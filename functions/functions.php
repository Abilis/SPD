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
    $query = "SELECT * FROM `spd_table` WHERE `ip_address` LIKE '%$ip_address%' ORDER BY `id_entry` DESC";
    
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
    $query = "SELECT * FROM `spd_table` WHERE `last_editor` LIKE '%$last_editor%' ORDER BY `dt_last_edited` DESC";
    
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

function entry_add($link, $user, $numOrder, $customer, $tarif, $ip_address, $netmask, $gateway, $vlan_id, $customer_port, $termination_point, $commentary) {
    
    /*обязательные аргументы: $customer, $ip_address, $vlan_id. Если они не переданы - запись в БД невозможа. Если что-то из остальных равно null, запись возможна */
    
    //проверка на наличие прав
    require_once('access.php');
    $canDoAdd = canDo($link, $user, 'ADD_ENTRY');
    if (!$canDoAdd) {
        header('Location: index.php');
        die();
    }
    
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
    $dt_added = date('Y.m.d G:i:s', time() + 3600 * 3);
    $dt_last_edited = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    $founder = $user['login'];
    $last_editor = $user['login'];
    
    //дополнительные параметры: $subnet (subnet); $broadcast (broadcast); $founder (founder)
    
    //формируем запрос
    $sql = "INSERT INTO spd_table 
                                (numOrder, customer, tarif, ip_address,
                                netmask, gateway, vlan_id, customer_port,
                                termination_point, dt_added, commentary,
                                dt_last_edited, founder, last_editor)
                                    VALUES 
                                        ('%d', '%s', '%s', '%s', '%s', '%s', '%d',
                                        '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    
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
                    mysqli_real_escape_string($link, $commentary),
                    mysqli_real_escape_string($link, $dt_last_edited),
                    mysqli_real_escape_string($link, $founder),
                    mysqli_real_escape_string($link, $last_editor));
    
    //наконец-то его можно выполнить!
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die('Не получилось :(' . mysqli_error());
    }
    
    //Запись в сессию о том, что добавление прошло успешно
    $_SESSION['add_success'] = "Запись успешно добавлена!";
    
    //Запись в лог
    //Формирование $entry_for_log
    $entry_for_log = array();
    
    $entry_for_log['numOrder'] = $numOrder;
    $entry_for_log['customer'] = $customer;
    $entry_for_log['tarif'] = $tarif;
    $entry_for_log['ip_address'] = $ip_address;
    $entry_for_log['netmask'] = $netmask;
    $entry_for_log['gateway'] = $gateway;
    $entry_for_log['vlan_id'] = $vlan_id;
    $entry_for_log['customer_port'] = $customer_port;
    $entry_for_log['termination_point'] = $termination_point;
    $entry_for_log['commentary'] = $commentary;
    
    //подключение файла с функцией логирования
    require_once('logging.php');
        
    if (!logging($link, $founder, 'добавление', null, $entry_for_log, $dt_added)) {
                //Запись в сессию в случае неудачного логирования
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }  
    
    return true;
}

function delete_entry($link, $user, $id_entry) {
    
    //проверка на наличие прав
    require_once('access.php');
    $canDoAdd = canDo($link, $user, 'DELETE_ENTRY');
    if (!$canDoAdd) {
        header('Location: index.php');
        die();
    }
    
    //Сначала пишем в лог
    //Формирование $entry_for_log
        
    //Формирование нового запроса, чтобы понять, что будем удалять
    $sql_for_log = "SELECT * FROM `spd_table` WHERE `id_entry` ='%d'";
    
    $query_for_log = sprintf($sql_for_log,
                    mysqli_real_escape_string($link, $id_entry));
    
    //выполняем запрос на выборку
    $result_for_log = mysqli_query($link, $query_for_log);
    
    if (!$result_for_log) {
        die($id_entry . mysql_error());
    }
    
    //Разбираем дескриптор в ассоциативный массив
    $entry_for_log = mysqli_fetch_assoc($result_for_log);
        
    //подключение файла с функцией логирования
    require_once('logging.php');
    
    //установка текущей даты
    $dt_added = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    //Определение логина
    $founder = $user['login'];
        
    if (!logging($link, $founder, 'удаление', $entry_for_log, null, $dt_added)) {
                //Запись в сессию в случае неудачного логирования
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }  //логирование завершено
    
    //Теперь формируем запрос для удаления
    $sql_delete = "DELETE FROM `spd_table` WHERE `id_entry` ='%d'";
    
    $query_for_delete = sprintf($sql_delete,
                    mysqli_real_escape_string($link, $id_entry));
    
    //выполняем запрос на удаление
    $result_for_delete = mysqli_query($link, $query_for_delete);
    
    if (!result_for_delete) {
        die('Не удалось удалить запись с id = ' . $id_entry . mysql_error());
    }
    
    //Запись в сессию о том, что удаление прошло успешно
    $_SESSION['delete_success'] = "Запись успешно удалена!";
    
    return true;
}

function entry_edit($link, $user, $id_entry, $numOrder, $customer, $tarif, $ip_address, $netmask, $gateway, $vlan_id, $customer_port, $termination_point, $commentary) {
    
    /*обязательные аргументы: $id_entry, $customer, $ip_address, $vlan_id. Если они не переданы - запись в БД невозможа. Если что-то из остальных равно null, запись возможна */
    
    //проверка на наличие прав
    require_once('access.php');
    $canDoAdd = canDo($link, $user, 'EDIT_ENTRY');
    if (!$canDoAdd) {
        header('Location: index.php');
        die();
    }
    
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
    $dt_last_edited = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    //Определение логина
    $last_editor = $user['login'];
    
    //формируем запрос для логирования
    $sql_for_log_old = "SELECT * FROM `spd_table` WHERE `id_entry` ='%d'";
    
    $query_for_log_old = sprintf($sql_for_log_old,
                    mysqli_real_escape_string($link, $id_entry));
    
    //выполняем запрос на выборку
    $result_for_log_old = mysqli_query($link, $query_for_log_old);
    
    if (!$result_for_log_old) {
        die($id_entry . mysql_error());
    }
    
    //Разбираем дескриптор в ассоциативный массив
    $entry_for_log_old = mysqli_fetch_assoc($result_for_log_old);
    
    //Теперь делаем UPDATE            
    //дополнительные параметры: $subnet (subnet); $broadcast (broadcast); $founder (founder)
    
    //формируем запрос
    $sql_for_update = "UPDATE spd_table SET
                                numOrder='%d', customer='%s', tarif='%s', ip_address='%s',
                                netmask='%s', gateway='%s', vlan_id='%d', customer_port='%s',
                                termination_point='%s', dt_last_edited='%s', commentary='%s',
                                last_editor='%s'
                                WHERE id_entry='%d'";
    
    $query_for_update = sprintf($sql_for_update,
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
                    mysqli_real_escape_string($link, $last_editor),
                    mysqli_real_escape_string($link, $id_entry));
    
    //Выполняем UPDATE
    $result_for_update = mysqli_query($link, $query_for_update);
    
    if (!$result_for_update) {
        die('Не получилось :(' . mysqli_error());
    }
    
    
    //Теперь формируем запрос на логирование, чтобы получить отредактированную запись
    
    $sql_for_log_new = "SELECT * FROM `spd_table` WHERE `id_entry` ='%d'";
    
    $query_for_log_new = sprintf($sql_for_log_new,
                    mysqli_real_escape_string($link, $id_entry));
    
    //выполняем запрос на выборку
    $result_for_log_new = mysqli_query($link, $query_for_log_new);
    
    if (!$result_for_log_new) {
        die($id_entry . mysql_error());
    }
    
    //Разбираем дескриптор в ассоциативный массив
    $entry_for_log_new = mysqli_fetch_assoc($result_for_log_new);
    
    
    //В этом местей у нас есть $entry_for_log_old со старым вариантом записи и $entry_for_log_new с новым
        
    //Теперь совершаем логирование
    
    //подключение файла с функцией логирования
    require_once('logging.php');
    
    if (!logging($link, $last_editor, 'правка', $entry_for_log_old, $entry_for_log_new, $dt_last_edited)) {
                //Запись в сессию в случае неудачного логирования
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }  //логирование завершено
        
    //окончание логирования
        
    //Запись в сессию о том, что редактирование прошло успешно
    $_SESSION['edit_success'] = "Запись успешно изменена!";
    
    return true;
}



//функция разлогинивания
function logout() { 
    setcookie('login', '', time() - 1, '/');
    setcookie('password', '', time() - 1, '/');
    unset($_COOKIE['login']);
    unset($_COOKIE['password']);
    unset($_SESSION['sid']);
    $sid = null;    
}

//функция залогинивания
//return true - залогинивание успешно, return false - неуспешно
function login($link, $login, $password, $remember){
    
    //вытаскиваем пользователя из БД
    $user = getByLogin($link, $login); //database.php
    
    if ($user == null) {
        
        //Запоминаем в сессии результат логина
        $_SESSION['login_success'] = 'Неверно введен логин или пароль!';
        return false; //если не удалось найти пользователя с таким логином
    }
    
    $id_user = $user['id_user']; //из полученного ассоциативного массива
    
    //Проверяем пароль
    if ($user['password'] != md5($password)) {
        
        //Запоминаем в сессии результат логина
        $_SESSION['login_success'] = 'Неверно введен логин или пароль!';
        return false; //если пароль в БД не совпадает с введенным
    }
    
    //если было установлено "запомнить меня", вешаем куки на логин и пароль
    if ($remember) {
        $expire = time() + 3600 * 24 * 7 + 3600 * 3;
        setcookie('login', $login, $expire, '/');
        setcookie('password', md5($password), $expire, '/');
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
    $now = date('Y.m.d G:i:s', time() + 3600 * 3);
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


//Генерация случайной последовательности символов
function generateStr($length) {
    
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = iconv_strlen($chars) - 1;
    
    while (iconv_strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    
    return $code;
}

//Определение имени текущего пользователя
function getCurrentUser($link) {
    
    //Сначала ищем sid в $_SESSION
    $sid = getSidInSession($link);
    
    //Если там найти ничего не удалось, то ищем в куках
    if ($sid == null) {
        
        $sid = getSidInCookie($link);
            
            if ($sid == null) {
                //если и в куках не удалось найти, значит, пользователь неавторизован
                return null;
            }
            
        
        
    } //конец поиска sid в куках
    //раз мы пришли сюда, значит, в $sid что-то есть
    //Извлекаем из БД из таблицы sessions $id_user
    
    //формируем запрос    
    $sql = mysqli_real_escape_string($link, $sid);
    
    $query = "SELECT * FROM sessions WHERE `sid`='$sql'";
    
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error());
    }
    
    //разбираем дескриптор в массив
    $array = mysqli_fetch_assoc($result);
    $id_user = $array['id_user']; 
    
    
    //Извлекаем из БД из таблицы users поле login для полученного $id_user
    
    //формируем запрос
    $sql = mysqli_real_escape_string($link, $id_user);
    
    $query = "SELECT * FROM users WHERE `id_user`='$sql'";
    
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        dir(mysqli_error());
    }
    
    //разбираем дескриптор в массив
    $user = mysqli_fetch_assoc($result);
            
    return $user;
}

//Поиск $sid в $_SESSION
function getSidInSession($link) {
    
    $sid = $_SESSION['sid'];
    
    if ($sid == null) {
        return null;
    }
    
    //Если же в $sid что-то есть, делаем запрос в БД
    $time_last = date('Y.m.d G:i:s', time() + 3600 * 3);
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
    //Значит, в БД была запись о сессии. И полученная $sid верна
    if ($affected_rows == 1) {
        return $sid;        
    }
    
    //Если же было затронуто 0 строк, это еще не значит, что в БД не было записи о сессии.
    //Поэтому нужно сделать проверку по SELECT
    if ($affected_rows == 0) {
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

        if ($sid == null) {
            return null;
        }
        
        //Если в результате этих манипуляций в $sid что-то есть, возвращаем его
        return $sid;
    }   
    
    //
    return $sid;
}

//Поиск $sid в куках
function getSidInCookie($link) {
    
    $login = $_COOKIE['login'];
    $password = $_COOKIE['password'];
    
    if ($login == null) {
        return null;
    }
    
    //Если же в куках есть какой-то логин, то ищем его в БД
    $user = getByLogin($link, $login);
    
    //Если что-то находится и пароль в базе совпадает с паролем из кук, то заново открываем сессию
    if ($user != null && $user['password'] == $password) {
        $sid = open_session($link, $user['id_user']);
    }
    
    
    return $sid;
}

//функция возвращает массив пользователей онлайн
function getWhoIsOnline($link) {
    
    //формируем запрос для вытаскивания логинов залогиненных пользователей
    $query = "SELECT DISTINCT `login` FROM `users` JOIN `sessions` ON users.id_user = sessions.id_user";
    
    //Выполняем запрос
    $result = mysqli_query($link, $query);

    if (!$result) {
        die(mysqli_error($link));
    }
    
    //разбираем дескриптор в ассоциативный массив
    
    //Извлечение из БД
    $n = mysqli_num_rows($result);
    $whoUsersOnline = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $whoUsersOnline[] = $row;
    }
    
    $whoUsersOnline_arr[0] = $whoUsersOnline;
    $whoUsersOnline_arr[1] = $n;    
            
    return $whoUsersOnline_arr;
}

//Функция возвращает массив с логами
function getLogs($link, $whichLog) {
    
    //подготовка
    $whichLog = mysqli_real_escape_string($link, $whichLog);
    
    //Запрос
    $query = "SELECT * FROM `$whichLog` ORDER BY `id_log` DESC";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Разбираем дескриптор в ассоциативный массив
    //Извлечение из БД
    $n = mysqli_affected_rows($link);
    $logs = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $logs[] = $row;
    }    
    
    return $logs;
}

//функция преобразует старые логи в массив массивов логов для показа в панели администратора
function format_log($logs, $whichLog, $num) { 

    //Создание массивов
    $arrayLogInside = array();
    $arrayLogs = array();

    for ($i = 0; $i < $num; $i++) {
        
        

        $format_current_log = explode(";", $logs[$i][$whichLog]);

        $arrayLogInside[0] = iconv_substr($format_current_log[1], 12);
        $arrayLogInside[1] = iconv_substr($format_current_log[2], 12);
        $arrayLogInside[2] = iconv_substr($format_current_log[3], 9);
        $arrayLogInside[3] = iconv_substr($format_current_log[4], 14);
        $arrayLogInside[4] = iconv_substr($format_current_log[5], 11);
        $arrayLogInside[5] = iconv_substr($format_current_log[6], 11);
        $arrayLogInside[6] = iconv_substr($format_current_log[7], 11);
        $arrayLogInside[7] = iconv_substr($format_current_log[8], 17);
        $arrayLogInside[8] = iconv_substr($format_current_log[9], 21);
        $arrayLogInside[9] = iconv_substr($format_current_log[14], 14);

        $arrayLogs[$i] = $arrayLogInside;

    }
    
    
    
    return $arrayLogs;
}

//функция преобразует новые логи в массив массивов логов для показа в панели администратора
function format_new_log($logs, $whichLog, $num) {
    
    //Создание массивов
    $arrayLogInside = array();
    $arrayLogs = array();
    
    
    //магия! не трогать!
        for ($i = 0; $i < $num; $i++) {
            
            if ($logs[$i]['action'] == "добавление") {
                
                $format_current_log = explode(";", $logs[$i]['entry_new_log']);
            
                $arrayLogInside[0] = iconv_substr($format_current_log[0], 10);
                $arrayLogInside[1] = iconv_substr($format_current_log[1], 12);
                $arrayLogInside[2] = iconv_substr($format_current_log[2], 9);
                $arrayLogInside[3] = iconv_substr($format_current_log[3], 13);
                $arrayLogInside[4] = iconv_substr($format_current_log[4], 10);
                $arrayLogInside[5] = iconv_substr($format_current_log[5], 10);
                $arrayLogInside[6] = iconv_substr($format_current_log[6], 10);
                $arrayLogInside[7] = iconv_substr($format_current_log[7], 17);
                $arrayLogInside[8] = iconv_substr($format_current_log[8], 20);
                $arrayLogInside[9] = iconv_substr($format_current_log[9], 13);

                $arrayLogs[$i] = $arrayLogInside;
                
            }
            
        else {
                                        
                $format_current_log = explode(";", $logs[$i][$whichLog]);
                
                $arrayLogInside[0] = iconv_substr($format_current_log[1], 12);
                $arrayLogInside[1] = iconv_substr($format_current_log[2], 12);
                $arrayLogInside[2] = iconv_substr($format_current_log[3], 9);
                $arrayLogInside[3] = iconv_substr($format_current_log[4], 13);
                $arrayLogInside[4] = iconv_substr($format_current_log[5], 10);
                $arrayLogInside[5] = iconv_substr($format_current_log[6], 10);
                $arrayLogInside[6] = iconv_substr($format_current_log[7], 10);
                $arrayLogInside[7] = iconv_substr($format_current_log[8], 16);
                $arrayLogInside[8] = iconv_substr($format_current_log[9], 21);
                $arrayLogInside[9] = iconv_substr($format_current_log[14], 14);

                $arrayLogs[$i] = $arrayLogInside;

            }            
                        
        }
    
    
    
    return $arrayLogs;
}


//Функция создает названия полей для отображения логов в панели администратора
function createLogName() {
    
    $log_name = array();
    $log_name[0] = "№ дог.";
    $log_name[1] = "Клиент";
    $log_name[2] = "Скорость";
    $log_name[3] = "IP-адрес";
    $log_name[4] = "Маска";
    $log_name[5] = "Шлюз";
    $log_name[6] = "Влан";
    $log_name[7] = "Порт клиента";
    $log_name[8] = "Терминация";
    $log_name[9] = "Комментарий";
    
    return $log_name;
}

//функция вытаскивает из БД сообщение дня в панели администратор
function get_motd($link) {
    
   //формируем запрос
    $sql = "SELECT * FROM `motd`";
        
    //Выполняем запрос
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        die(mysqli_error());
    }
    
    //Собираем из дескриптора ассоциативный массив
    $motd = mysqli_fetch_assoc($result); 
    
    return $motd  ;  
}

//Функция обновляет сообщение дня в панели администратора
function updateMotd($link, $user, $motd) {
    
    //Подготовка
    $motd = trim($motd);
    
    if ($motd == '') {
        return false;
    }
    
    //проверка на наличие прав
    require_once('access.php');
    $canDoAdd = canDo($link, $user, 'EDIT_MOTD');
    if (!$canDoAdd) {
        header('Location: index.php');
        die();
    }
    
    //Экранирование html-тегов
    $motd = htmlspecialchars($motd);
    
    //установка текущей даты
    $dt_motd = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    //Установка Текущего пользователя в качестве автора
    $autor = $user['login'];
    
    //формируем запрос
    $sql = "UPDATE `motd` SET `text`='%s', `autor`='%s', `dt_motd`='%s'";
    
    $query = sprintf($sql,  mysqli_real_escape_string($link, $motd),
                            mysqli_real_escape_string($link, $autor),
                            mysqli_real_escape_string($link, $dt_motd));
    
    //выполняем запрос
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_errror());
    }
    
    return true;
}

//функция создает нового пользователя
function createNewUser($link, $user, $login, $password, $confirmPassword, $username, $access) {
  
    //Определяем, может ли пользователь управлять пользователями
    $canDoUsersControl = canDo($link, $user, 'USERS_CONTROL');
    
    //Определяем, может ли пользователь управлять пользователями (расширенный вариант)
    $canDoSuperusersControl = canDo($link, $user, 'SUPERUSERS_CONTROL');

    if (!$canDoUsersControl) {        
        return false;
    }
    
    //проверяем, совпадают ли введенные пароли
     if ($password != $confirmPassword) {
         
         $_SESSION['CreateUser'] = "Пароли не совпадают!";                 
         return false;
     }
    
    //проверка значимых полей
    if ((!isset($login) || !isset($password) || !isset($confirmPassword))) {
        
        $_SESSION['CreateUser'] = "Не отмечено одно из полей!";        
        return false;
    }
    
    
    //выбор id_role
    if ($access == 'accessUser') {
        $id_role = 1;
    }
    elseif ($access == 'accessOperator') {
        $id_role = 2;
    }
    elseif ($access == 'accessAdministrator') {
        $id_role = 5;
    }
    elseif ($access == 'accessMainAdministrator') {
        
        if (!$canDoSuperusersControl) { //невозможно создать полного администратора без привилегии SUPERUSERS_CONTROL
            $_SESSION['CreateUser'] = "Недостаточно прав!"; 
            return false;            
        }
        else {
            $id_role = 10;
        }
    }
    else {
        return false;
    }
    
    //проверяем, нет ли в БД пользователя с таким логином
    
    $sqlFromDB = "SELECT `login` FROM `users` WHERE `login`='%s'";
    $queryFromDb = sprintf($sqlFromDB, mysqli_real_escape_string($link, $login));
    
    $resultFromDb = mysqli_query($link, $queryFromDb);
    
    if (!$resultFromDb) {
        die(mysqli_errror());
    }
    
    $num = mysqli_affected_rows($link);
    if ($num != 0) {
        
        $_SESSION['CreateUser'] = "Пользователь с логином $login уже существует!"; 
        return false;
    }
    
    //если дошли до сюда, значит, можно создавать пользователя
    
    $password = md5($password);
    
    $sqlCreateUser = "INSERT INTO `users` (`login`, `password`, `id_role`, `name`) VALUES ('%s', '%s', '%d', '%s')";
    
    $queryCreateUser = sprintf($sqlCreateUser, mysqli_real_escape_string($link, $login),
                                                mysqli_real_escape_string($link, $password),
                                                mysqli_real_escape_string($link, $id_role),
                                                mysqli_real_escape_string($link, $username));
        
    $resultCreateUser = mysqli_query($link, $queryCreateUser);
    
    if (!$resultCreateUser) {
        die(mysqli_errror());
    }
    
    //если все успешно - записываем результат в сессию
    $_SESSION['CreateUser'] = "Пользователь $login успешно создан!"; 
    
    //и записываем в лог
    
    //устанавливаем дату
    $dt_action = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    //определяем переменную $access_level
    if ($id_role == 1) {
        $access_level = "пользователя";
    }
    elseif ($id_role == 2) {
        $access_level = "оператора";
    }
    elseif ($id_role == 5) {
        $access_level = "администратора";
    }
    elseif ($id_role == 10) {
        $access_level = "главного администратора";
    }
    else {
        $access_level = "неизвестного ползователя";
    }
    
    //вытаскиваем имя текущего пользователя, чтобы можно было подставить значение в строку сообщения
    $userLogin = $user['login'];
    
    $message = "Создан новый пользователь с логином \"$login\", именем \"$username\", правами $access_level пользователем $userLogin";
    
    //подключение файла с функцией логирования
    require_once('logging.php');
    
    //выполняем логирование
    if (!loggingAction($link, $user, $message, $dt_action)) {
        //запись неиспешности в сессию
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }
    
    
    return true;
}

//Вытаскиваем из БД $num строк начиная с номера $start для постраничного вывода логов на странице all-logs.php
function get_logs_num_start($link) {
    
    $num = 50; //число выводимых записей
    
    //Извлекаем из URL текущую страницу
    $page = (int)($_GET['page']);
    
    //Определяем общее число записей в БД
    $query = "SELECT COUNT(*) FROM `logs`";
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
    $query = "SELECT * FROM `logs` ORDER BY `dt_action` DESC LIMIT $start, $num";
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
    $entries_arr[3] = $num_rows;
    
    return $entries_arr;
}

//Функция для получения всех пользователей системы
function getUsers($link) {
    
   //Запрос
    $query = "SELECT * FROM `users` ORDER BY `id_user` DESC";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Извлечение из БД
    $n = mysqli_num_rows($result);
    $users = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $users[] = $row;
    }
    
    $users_arr[0] = $users;
    $users_arr[1] = $n;
    
    return $users_arr; 
    
}

//Функция, очищающие логи, старше 3х месяцев
function deleteOldLogs($link, $user) {
    
    //Проверка прав
    require_once('access.php');
    $canDoDeleteOldLogs = canDo($link, $user, 'DELETE_OLD_LOGS');
    
    if (!$canDoDeleteOldLogs) {
        $_SESSION['deleteOldLogs'] = "Недостаточно прав для удаления логов!";
        header('Location: all_logs.php');
        die();
    }
    
    //установка даты
    $dt_min = date('Y.m.d G:i:s', time() + 3600 * 3 - 3600 * 24 * 90);
    
    //формируем запрос
    $sql = "DELETE FROM `logs` WHERE `dt_action` < '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($link, $dt_min));
    
    //выполнение запроса
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    
    $n1 = mysqli_affected_rows($link);
    
    
    //удаление старых логов событий
    //формируем запрос
    $sql = "DELETE FROM `logs_action` WHERE `dt_action` < '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($link, $dt_min));
    
    //выполнение запроса
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    
    $n2 = mysqli_affected_rows($link);
    
    //Общее количество удаленных логов
    $n = $n1 + $n2;
        
    //Запись в сессии
    $_SESSION['deleteOldLogs'] = "Операция успешно завершена. Удалено $n строк.";
    
    
    //записываем в лог действий
    //вытаскиваем имя текущего пользователя, чтобы можно было подставить значение в строку сообщения
    $userLogin = $user['login'];
    
    $dt_action = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    $message = "Пользователем $userLogin удалены старые логи в количество $n строк ($n1 общих логов и $n2 логов действий).";
    
    //подключение файла с функцией логирования
    require_once('logging.php');
    
    //выполняем логирование
    if (!loggingAction($link, $user, $message, $dt_action)) {
        //запись неиспешности в сессию
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }   
    
    
    
    return true;
}

//функция возвращает количество логов
function getNumLogs($link) {
    
    //Запрос
    $query = "SELECT COUNT(*) FROM `logs`";
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
        
    $numLOgs = mysqli_fetch_row($result)[0];
            
    return $numLOgs;
}

//Функция генерация сети из панели администратора
function networkGeneration($link, $user, $markAddress, $network, $broadcast, $vlan, $termination) {
    
    //проверка прав
    require_once('access.php');
    $canDoNetworkGeneration = canDo($link, $user, 'NETWORK_GENERATION');
    
    if (!$canDoNetworkGeneration) {
        $_SESSION['networkGeneration'] = "Недостаточно прав для генерации сети!";
        return false;
    }
    
    //Вытаскиваем последние числа из $network и $broadcast    
    $firstOctetArr = explode('.', $network);
    $firstOctet = $firstOctetArr[3];    

    if (($firstOctetArr[0] == null) || ($firstOctetArr[1] == null) || ($firstOctetArr[2] == null) ||       ($firstOctetArr[3]) == null) {        
        
        $_SESSION['networkGeneration'] = "Введенный адрес сети не является допустимым адресом!";
        return false;
    }
    
    $lastOctetArr = explode('.', $broadcast);
    $lastOctet = $lastOctetArr[3];
    
    if (($lastOctetArr[0] == null) || ($lastOctetArr[1] == null) || ($lastOctetArr[2] == null) ||       ($lastOctetArr[3]) == null) {
        
        $_SESSION['networkGeneration'] = "Введенный адрес бродкаста не является допустимым адресом!";
        return false;
    }
    
    
    //проверки на существование адресов
    if ($firstOctet > 255 || $firstOctet < 0) {
        $_SESSION['networkGeneration'] = "Последний октет адреса сети должен быть в диапазоне 0 - 255!";
        return false;
    }
    
    if ($lastOctet > 255 || $lastOctet < 0) {
        $_SESSION['networkGeneration'] = "Последний октет бродкаста должен быть в диапазоне 0 - 255!";
        return false;
    }
    
    //Проверка на принадлежность сети и бродкаста одному диапазону
    $networkStr = $firstOctetArr[0] . $firstOctetArr[1] . $firstOctetArr[2];
    $broadcastArr = $lastOctetArr[0] . $lastOctetArr[1] . $lastOctetArr[2];
    
    if ($networkStr != $broadcastArr) {
        $_SESSION['networkGeneration'] = "Сеть и бродкаст не принадлежат одному диапазону!";
        return false;
    }
    
    //количество адресов, которое необходимо сгенерить
    $numAddresses = $lastOctet - $firstOctet + 1;
    
    //Преобразуем в строку первые три октета сети вместе с точкой в конце
    unset($firstOctetArr[3]);    
    $firstThreeOctetsOfNetwork = implode('.', $firstOctetArr) . '.';
    
    unset($lastOctetArr[3]);
    $lastThreeOctetsOfBroadcast = implode('.', $lastOctetArr) . '.';
    
    //Проверка на существование записей с адресами из генерируемого диапазона в БД    
    
    for ($i = 0; $i < $numAddresses; $i++) {
        
        $ipAddressForQuery = $firstThreeOctetsOfNetwork . ($firstOctet + $i);
        $sql = "SELECT `ip_address` FROM `spd_table` WHERE `ip_address`='%s'";
        $query = sprintf($sql, mysqli_real_escape_string($link, $ipAddressForQuery));        

        $result = mysqli_query($link, $query);
        
        if (!$result) {
            die(mysqli_error($link));
        }
        
        $num = mysqli_fetch_row($result)[0];
        
        if ($num != 0) {
            
            $_SESSION['networkGeneration'] = "Адрес $ipAddressForQuery уже существует!";
            return false;
        }
        
    }
    
    
    //проверка на существование влан
    if ($vlan < 2 || $vlan > 4095) {
        $_SESSION['networkGeneration'] = "Не может быть влана с номером $vlan!";
            return false;
    }
    
    //проверка на существование записей с таким вланом в БД
    
    $sql = "SELECT `vlan_id` FROM `spd_table` WHERE `vlan_id`='%d'";
    $query = sprintf($sql, mysqli_real_escape_string($link, $vlan));
        
    $result = mysqli_query($link, $query);
        
    if (!$result) {
            die(mysqli_error($link));
    }
    
    $num = mysqli_fetch_row($result)[0];
        
    if ($num != 0) {

        $_SESSION['networkGeneration'] = "Влан $vlan уже существует!";
        return false;
    }
    
    //установка переменных
    $dt_added = date('Y.m.d G:i:s', time() + 3600 * 3);
    $dt_last_edited = date('Y.m.d G:i:s', time() + 3600 * 3);
    
    $founder = $user['login'];
    $last_editor = $user['login'];
    
    //установка шлюза
    $gateway = $firstThreeOctetsOfNetwork . ($firstOctet + 1);
        
    
    
    //установка маски и подсети. Здесь $numAddresses - полное количество адресов в сети
    
        switch ($numAddresses) {
                case 4:     $netmask = '255.255.255.252';
                            $subnet = $network . '/30';
                            break;
                case 8:      $netmask = '255.255.255.248';
                            $subnet = $network . '/29';
                            break;
                case 16:     $netmask = '255.255.255.240';
                            $subnet = $network . '/28';
                            break;
                case 32:    $netmask = '255.255.255.224';
                            $subnet = $network . '/27';
                            break;
                case 64:    $netmask = '255.255.255.192';
                            $subnet = $network . '/26';
                            break;
                case 128:   $netmask = '255.255.255.128';
                            $subnet = $network . '/25';
                            break;
                case 256:   $netmask = '255.255.255.0';
                            $subnet = $network . '/24';
                            break;
                default:  $_SESSION['networkGeneration'] = "Не удалось вычислить маску для полного числа адресов                                                            $numAddresses";
                            return false;
                
                
                
        }
    
    
    //корректируем число $numAddresses. Исключаем адреса сети, бродкаста и шлюза
    $numAddresses -= 3;
    
    //Все проверки пройдены, теперь можно делать генерацию
    for ($i = 0; $i < $numAddresses; $i++) {
        
        $ipAddressForQuery = $firstThreeOctetsOfNetwork . ($firstOctet + $i + 2);
        $sql = "INSERT INTO `spd_table`
                            (`customer`, `ip_address`, `netmask`, `gateway`, `vlan_id`,
                            `termination_point`, `subnet`, `broadcast`, `dt_added`,
                            `dt_last_edited`, `founder`, `last_editor`)
                        VALUES 
                        ('%s', '%s', '%s', '%s', '%d',
                        '%s', '%s', '%s', '%s',
                        '%s', '%s', '%s')";
        
        $query = sprintf($sql, mysqli_real_escape_string($link, $markAddress),
                             mysqli_real_escape_string($link, $ipAddressForQuery),
                             mysqli_real_escape_string($link, $netmask),
                             mysqli_real_escape_string($link, $gateway),
                             mysqli_real_escape_string($link, $vlan),
                             mysqli_real_escape_string($link, $termination),
                             mysqli_real_escape_string($link, $subnet),
                             mysqli_real_escape_string($link, $broadcast),
                             mysqli_real_escape_string($link, $dt_added),
                             mysqli_real_escape_string($link, $dt_last_edited),
                             mysqli_real_escape_string($link, $founder),
                             mysqli_real_escape_string($link, $last_editor),
                             mysqli_real_escape_string($link, $markAddress)  );
        
        
        
        $result = mysqli_query($link, $query);
        
        if (!$result) {
            die("Не удалось добавить адрес $ipAddressForQuery" . mysqli_error($link));
        }
        
        $num = mysqli_fetch_row($result)[0];   

    }
    
    //Запись в сессию
    $_SESSION['networkGeneration'] = "Сеть $network с пометкой свободных адресов \"$markAddress\" успешно создана! Влан $vlan терминируется на $termination. Шлюз установлен как $gateway. Добавлено адресов: $numAddresses";
    
    
    //записываем в лог действий
    //вытаскиваем имя текущего пользователя, чтобы можно было подставить значение в строку сообщения
    $userLogin = $user['login'];
    
    $dt_action = $dt_added;
    
    $message = "Пользователем $userLogin создана сеть $network с пометкой свободных адресов \"$markAddress\". Влан $vlan терминируется на $termination. Шлюз установлен как $gateway. Добавлено адресов: $numAddresses";
    
    //подключение файла с функцией логирования
    require_once('logging.php');
    
    //выполняем логирование
    if (!loggingAction($link, $user, $message, $dt_action)) {
        //запись неиспешности в сессию
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }   
    
    
    return true;
}


?>
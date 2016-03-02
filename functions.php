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

function entry_add($link, $user, $numOrder, $customer, $tarif, $ip_address, $netmask, $gateway, $vlan_id, $customer_port, $termination_point, $commentary) {
    
    /*обязательные аргументы: $customer, $ip_address, $vlan_id. Если они не переданы - запись в БД невозможа. Если что-то из остальных равно null, запись возможна */
    
    //проверка на наличие прав
    
    $canDoAdd = canDo($link, $user, 'EDIT_ENTRY');
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
    
    $entry_for_log['№ договора'] = $numOrder;
    $entry_for_log['клиент'] = $customer;
    $entry_for_log['скорость'] = $tarif;
    $entry_for_log['IP-адрес'] = $ip_address;
    $entry_for_log['маска'] = $netmask;
    $entry_for_log['шлюза'] = $gateway;
    $entry_for_log['влан'] = $vlan_id;
    $entry_for_log['порт клиента'] = $customer_port;
    $entry_for_log['терминация'] = $termination_point;
    $entry_for_log['комментарий'] = $commentary;
    
    //подключение файла с функцией логирования
    require_once('logging.php');
        
    if (!logging($link, $founder, 'добавление', null, $entry_for_log, $dt_added)) {
                //Запись в сессию в случае неудачного логирования
        $_SESSION['logging'] = 'Логирование действия не удалось!';
    }  
    
    return true;
}

function delete_entry($link, $user, $id_entry) {
    
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
    setcookie('login', '', time() - 1);
    setcookie('password', '', time() - 1);
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
            
    return $whoUsersOnline;
}


?>
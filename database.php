<?php
function startup()
{
	// Настройки подключения к БД
	define('HOSTNAME', 'localhost'); 
	define('USERNAME', 'root'); 
	define('PASSWORD', '');
	define('DBNAME', 'spd');
	
	// Языковая настройка
	setlocale(LC_ALL, 'ru_RU.utf8');	
	
	// Подключение к БД.
	$link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD) or die('No connect with data base'); 
	mysqli_query($link, 'SET NAMES utf8');
	mysqli_select_db($link, DBNAME) or die('No data base');

	// Открытие сессии
	session_start();
    
	return $link;	
}

function getByLogin($link, $login) {
    
    
    
    //подготовка и проверка
    $login = trim($login);
    
    if ($login == "") {
        header('Location: login.php');
        die();
    }
    
    $login = mysqli_real_escape_string($link, $login);
       
    //Формируем запрос
    $sql = "SELECT * FROM users WHERE login = '%s'";
    $query = sprintf($sql, $login);
    
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error($link));
    }
    
    //Собираем из дескриптора ассоциативный массив
    $entry = mysqli_fetch_assoc($result);    
    
    return $entry;
}


function openSessionInDb($link, $session) {
    
    //Разбираем полученный массив $session
    $id_user = $session['id_user'];
    $sid = $session['sid'];
    $time_start = $session['time_start'];
    $time_last = $session['time_last'];
    
    //Формируем запрос
    $sql = "INSERT INTO sessions
            (id_user, sid, time_start, time_last)
            VALUES ('$id_user', '$sid', '$time_start', '$time_last')";
    
    //Выполняем запрос
    $result = mysqli_query($link, $sql);
    
    if (!result) {
        die(mysqli_error());
    }
    
    return true;
    
}




?>
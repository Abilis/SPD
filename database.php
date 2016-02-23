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

?>
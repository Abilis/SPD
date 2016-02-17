<?php
function startup()
{
	// Настройки подключения к БД.
	$hostname = 'localhost'; 
	$username = 'root'; 
	$password = '';
	$dbName = 'spd';
	
	// Языковая настройка.
	setlocale(LC_ALL, 'ru_RU.utf8');	
	
	// Подключение к БД.
	$link = mysqli_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysqli_query($link, 'SET NAMES utf8');
	mysqli_select_db($link, $dbName) or die('No data base');

	// Открытие сессии.
	session_start();
		
}

?>
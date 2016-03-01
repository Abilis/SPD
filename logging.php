<?php

//Функция записывает в БД запись о произведенном действии
function logging ($link, $login, $action, $entry_for_log, $dt_action) {
    
   if ($login == null || $action == null || $entry_for_log == null) {
        return false;
    }
    
    //Разбираем массив $entry_for_log в строку
    $entry_for_log_as_string = "";
        
    foreach ($entry_for_log as $key => $entry) {
         $entry_for_log_as_string .= $key . " = " . $entry . "; ";         
    }
    
    //формируем запрос
    $sql = "INSERT INTO logs
                            (login, action, entry_log, dt_action)
                            VALUES 
                                ('%s', '%s', '%s', '%s')";
    
    $query = sprintf($sql,
                     mysqli_real_escape_string($link, $login),
                     mysqli_real_escape_string($link, $action),
                     mysqli_real_escape_string($link, $entry_for_log_as_string),
                     mysqli_real_escape_string($link, $dt_action));
    
    //Выполнение запроса
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die('Не получилось :(' . mysqli_error());
    }  
    
    return true;
}

?>
<?php

//Функция записывает в БД запись о произведенном действии
function logging ($link, $login, $action, $entry_for_log_old, $entry_for_log_new, $dt_action) {
    
    
        
   if ($login == null || $action == null || (($entry_for_log_old == null) && ($entry_for_log_new == null))) {
       return false;
    }
    
    //Смотрим, что пришло в $entry_for_log_old и $entry_for_log_new
    if ($entry_for_log_old == null && $entry_for_log_new != null) { //значит, нужно логировать добавление записи
        $which_entry_log = 'entry_new_log';
        $entry_for_log = $entry_for_log_new;
               
    }
    elseif ($entry_for_log_old != null && $entry_for_log_new == null) { //значит, нужно логировать удаление записи
        $which_entry_log = 'entry_old_log';
        $entry_for_log = $entry_for_log_old;
    }
    
    elseif ($entry_for_log_old != null && $entry_for_log_new != null) { //значит, нужно логировать редактирование записи записи
        
        //Разбираем массив $entry_for_log_old в строку $entry_for_log_as_string_old
        $entry_for_log_as_string_old = "";
        
        foreach ($entry_for_log_old as $key => $entry_for_log) {
             $entry_for_log_as_string_old .= $key . " = " . $entry_for_log . "; ";         
        }
        
        
        
        
        //Разбираем массив $entry_for_log_new в строку $entry_for_log_as_string_new
        $entry_for_log_as_string_new = "";
        
        foreach ($entry_for_log_new as $key => $entry_for_log) {
             $entry_for_log_as_string_new .= $key . " = " . $entry_for_log . "; ";         
        }
        
        
        //Экранирование
        $login = mysqli_real_escape_string($link, $login);
        $action = mysqli_real_escape_string($link, $action);
        $entry_for_log_as_string_old = mysqli_real_escape_string($link, $entry_for_log_as_string_old);
        $entry_for_log_as_string_new = mysqli_real_escape_string($link, $entry_for_log_as_string_new);
        $dt_action = mysqli_real_escape_string($link, $dt_action);
        
        //формируем запрос
        $query = "INSERT INTO logs
                                    (`login`, `action`, `entry_old_log`, `entry_new_log`, `dt_action`)
                                VALUES 
                                    ('$login', '$action', '$entry_for_log_as_string_old', '$entry_for_log_as_string_new', '$dt_action')";        
        
    
        //Выполнение запроса
        $result = mysqli_query($link, $query);

        if (!$result) {
            die('Не получилось :(' . mysqli_error());
        }  

        return true;
    } //конец логирования правки
    
    
    
    //Разбираем массив $entry_for_log в строку
    $entry_for_log_as_string = "";
        
    foreach ($entry_for_log as $key => $entry) {
         $entry_for_log_as_string .= $key . " = " . $entry . "; ";         
    }
    
    
    
    //формируем запрос
    $sql = "INSERT INTO logs
                            (`login`, `action`, `$which_entry_log`, `dt_action`)
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
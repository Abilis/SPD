<?php
//Обработка различный событий, связанных с доступом

//Функция, определяющая, есть ли права на просмотр, добавление, редактирование и удаление записей
function canDo($link, $user, $action) {
    
    //Получаем id_role пользователя
    $id_role = $user['id_role'];
    
    //Вытаскиваем привилегии, которые полагаются с данным id_role
    
    //Запрос
    $sql = mysqli_real_escape_string($link, $id_role);    
    $query = "SELECT `id_priv` FROM privs2roles WHERE `id_role`='$sql'";
    
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error());
    }
    
    //Перегонка результата в массив
    //Извлечение из БД
    $n = mysqli_num_rows($result);
    $entries = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $entries[] = $row;
    }
    
    //Ищем id_priv, необходимый для соверщения действия $action
    $sql = mysqli_real_escape_string($link, $action);
    $query = "SELECT `id_privs` FROM `privs` WHERE `name`='$sql'";
    
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        die(mysqli_error());
    }
    
    //Вытаскивание id_priv из результата
    $id_priv = mysqli_fetch_assoc($result)['id_privs'];
    
    //Поиск $id_priv в $entries. Успешное нахождение будет означать наличие привилегии        
    foreach ($entries as $entry) {
        if ($id_priv == $entry['id_priv']) {
            
            return true;
        } 
    }
        
    return false;
}


?>
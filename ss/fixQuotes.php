<?php
require_once('../functions/database.php');

// подключение к БД
$link = startup();

//вытащить из БД все строки, где есть символы " и заменить их на &quot;


//вхождение " в поле customer
$searchString = '\"';
$fixSubString = '\"';

//устанавливаем счетчик строк
$num = 0;

//формируем запрос
$sql = "SELECT * FROM `spd_table` WHERE `customer` LIKE '%$searchString%' ORDER BY `id_entry` ASC";

//выполняем запрос
$result = mysqli_query($link, $sql);

//разбираем дескриптор в ассоциативный массив
$n = mysqli_num_rows($result);
    $entriesForFix = array();
    
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $entriesForFix[] = $row;
    }


//Теперь проходим по полученному ассоциативному массиву и меняем в каждом значении по ключу customer " на &quot;

foreach ($entriesForFix as $entryForFix) {
    
    //вытаскиваем строку по ключу
    $stringForFix = $entryForFix['customer'];
    
    //изменяем строку в массиве
    str_replace($searchString, $fixSubString, $stringForFix);
    
    //записываем измененную строку обратно в массив
    $stringAfterFix = $entryForFix['customer'];
    
    //вытаскиваем id_entry
    $id_entry = $entryForFix['id_entry'];
    
    
    //формируем запрос для апдейта
    $sqlForUpdate = "UPDATE `spd_table` SET `customer`='%s' WHERE `id_entry` = '$id_entry'";
    
    $queryForUpdate = sprintf($sqlForUpdate, mysqli_real_escape_string($link, htmlspecialchars($stringAfterFix)));    
    
    //выполняем запрос
    $result = mysqli_query($link, $queryForUpdate);
    
    if (!$result) {
        die('Что-то пошло не так');
    }
    
    
    //увеличиваем число строк, затронутых преобразованием
    $num++;
    
}
echo "Замена кавычек успешно произведена в $num записях";

?>
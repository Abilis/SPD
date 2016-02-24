<?php
//require_once('database.php');
//без необходимости не расскоментировать

$timeBegin = time();

// подключение к БД
$link = startup();

$file_name = 'SPD.csv';

$numbers = 0;

if ( ($handle_o = fopen($file_name, "r") ) !== FALSE ) {
    
// читаем первую строку и разбираем названия полей
$columns_o = fgetcsv($handle_o, 1000, ";");
    
foreach( $columns_o as $v ) {
$insertColumns[]="`" . addslashes(trim($v)) . "`";
}
    
$columns=implode(',', $insertColumns);


while ( ($data_o = fgetcsv($handle_o, 1000, ";")) !== FALSE) {
    
$insertValues = array();
    
foreach( $data_o as $v ) {
$insertValues[]="'" . addslashes(trim($v)) . "'";
}
 

$values=implode(',',$insertValues);
    

    
$sql = "INSERT INTO spd_table ( $columns ) VALUES ( $values )";



    

    

    
$result = mysqli_query($link, $sql);


    
if (!$result) {
    die('Что-то пошло не так :(' . mysql_error());
}
  
$numbers++;
    

    
}

}
fclose($handle_o);

echo 'Добавлено строк: ' . $numbers . '<br />';

$timeFinish = time();
$timeGone = $timeFinish - $timeBegin;
echo 'Затрачено секунд: ' . $timeGone;


?>
<?php
error_reporting(E_ERROR);
require_once('../database.php');
require_once('../functions.php');
require_once('../access.php');

//подключение к БД
$link = startup();

//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь делать импорт
$canDoImportInDb = canDo($link, $user, 'IMPORT_IN_DB');

if (!$canDoImportInDb) {
    $_SESSION['noAccessImportInDb'] = "Недостаточно прав для импорта данных в БД!";
    header('Location: ../admin.php');
    die('не положено!');
}


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
include_once('views/v-header.php');

echo 'Добавлено строк: ' . $numbers . '<br />';

$timeFinish = time();
$timeGone = $timeFinish - $timeBegin;
echo 'Затрачено секунд: ' . $timeGone;?>
<br />
<br />
<a href="../index.php">На главную</a> <b>|</b> <a href="../admin.php">Вернуться в панель администратора</a>
<?php include_once('views/v-index.php');
?>

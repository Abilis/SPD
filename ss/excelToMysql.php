<?php
error_reporting(E_ERROR);
require_once('../functions/database.php');
require_once('../functions/functions.php');
require_once('../functions/access.php');

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

//Загрузка файла

if ($_FILES['filename']['size'] > 3000000) {
    
    echo 'Слишком большой размер файла!';
    die();
}

if ($_FILES['filename']['type'] != application/vnd.ms-excel) {
    
    echo 'Некорректный тип файла! Файл должен быть в формате .csv';
    die();
}


//Установка переменных
$tmpName = $_FILES['filename']['tmp_name'];
$name = 'spd.csv';

if (!move_uploaded_file($tmpName, $name)) {
    
   die('Не получилось загрузить файл :(');
}


//установка таблицы импорта
$tableName = mysqli_real_escape_string($link, $_POST['tableName']);



//начало исполнение импорта
$timeBegin = time();

$file_name = 'spd.csv';

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

//экранируем кавычки и прочую дрянь
$values = htmlspecialchars($values);
    
$sql = "INSERT INTO `$tableName` ( $columns ) VALUES ( $values )";
    
$result = mysqli_query($link, $sql);

    
if (!$result) {
    
    die('Что-то пошло не так :(' . mysql_error());
}
  
$numbers++;
    

    
}

}
fclose($handle_o);
unlink('spd.csv');


//записываем в лог действий
//вытаскиваем имя текущего пользователя, чтобы можно было подставить значение в строку сообщения
$userLogin = $user['login'];

//установка текущей даты
$dt_action = date('Y.m.d G:i:s', time() + 3600 * 3);

$message = "Пользователем $userLogin импортирован файл в БД в таблицу \"$tableName\". Добавлено строк: $numbers";

//подключение файла с функцией логирования
require_once('../functions/logging.php');

//выполняем логирование
if (!loggingAction($link, $user, $message, $dt_action)) {
    //запись неиспешности в сессию
    $_SESSION['logging'] = 'Логирование действия не удалось!';
}   



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
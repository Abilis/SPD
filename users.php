<?php
//скрипт для создания, редактирования и удаления пользователей
require_once('database.php');
require_once('functions.php');
require_once('access.php');

// подключение к БД
$link = startup();



//Определение текущего пользователя
$user = getCurrentUser($link);

//Определяем, может ли пользователь управлять пользователями
$canDoUsersControl = canDo($link, $user, 'USERS_CONTROL');

if (!$canDoUsersControl) {
    header('Location: index.php');
    die('123');
}

//Обработка формы
if (($_POST['login'] != null) && ($_POST['password'] != null)) { //если вбиты логин и пароль     
        
    if (createNewUser($link, $user, $_POST['login'], $_POST['password'], $_POST['confirmPassword'],
                      $_POST['username'], $_POST['access'])) {
        
        
        //если мы здесь, значит, пользователь успешно создался
        header('Location: admin.php');
        
    }
        
}

//если пустой - то делать тут нечего
header('Location: admin.php');
?>
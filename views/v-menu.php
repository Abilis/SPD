<?php 
error_reporting(E_ERROR);
if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b><br />
            <a href="logout.php">Выйти</a>
<?php } ?>

<?php if ($user == null) { ?>
            <a href="login.php">Войти</a>
            <br /><b>Вы не залогинены</b>
<?php } ?><br /><br />

<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="add.php">Добавить клиента</a>

<?php if ($canDoViewAdminPanel) { ?>
<b>|</b> <a href="admin.php">Панель администратора</a> 
<?php } ?>

<?php if (count($entries)) { ?>
<b>|</b> Найдено записей: <?=count($entries)?>

<?php }

if ($numEntriesAll) { ?> 
<b>|</b> Всего записей: <?=$numEntriesAll?>
<?php } ?>

<br />

<?php
//Отображение успешности добавления, правки и удаления записи
if (isset($_SESSION['add_success'])) {
    echo '<span class="bold">' . $_SESSION['add_success'] . '</span>';
    $_SESSION['add_success'] = null;
}
else if (isset($_SESSION['edit_success'])) {
    echo '<span class="bold">' . $_SESSION['edit_success'] . '</span>';
    $_SESSION['edit_success'] = null;
}
else if (isset($_SESSION['delete_success'])) {
    echo '<span class="bold">' . $_SESSION['delete_success'] . '</span>';
    $_SESSION['delete_success'] = null;
}

//Отображение неуспешности логирования
if (isset($_SESSION['logging'])) {
    echo '<span class="bold"> ' . $_SESSION['logging'] . '</span>';
    $_SESSION['logging'] = null;
}
?>
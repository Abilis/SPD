<?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b><br />
            <a href="logout.php">Выйти</a>
<?php } ?>

<?php if ($user == null) { ?>
            <a href="login.php">Войти</a>
            <br /><b>Вы не залогинены</b>
<?php } ?><br /><br />

<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="add.php">Добавить клиента</a> <b>|</b> Найдено записей: <?=count($entries)?> <b>|</b> Всего записей: <?=$numEntriesAll?>
<br />
<?php
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
?>
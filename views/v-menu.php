<?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b><br />
            <a href="logout.php">Выйти</a>
<?php } ?>

<?php if ($user == null) { ?>
            <a href="login.php">Войти</a>
            <br /><b>Вы не залогинены</b>
<?php } ?><br /><br />

<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="add.php">Добавить клиента</a> <b>|</b> Найдено записей: <?=count($entries)?> <b>|</b> Всего записей: <?=$numEntriesAll?>
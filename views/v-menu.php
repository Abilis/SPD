<a href="login.php">Войти/выйти</a>
<?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b>
<?php } ?><br /><br />

<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a> <b>|</b> Найдено записей: <?=count($entries)?> <b>|</b> Всего записей: <?=$numEntriesAll?>
<?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b>
<?php } ?><br /><br />
<form action="logout.php" method="post">
    <tr >
        <td><input type="submit" value="Выйти"/>
        </td>
    </tr>
</form>
<br />
<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a>
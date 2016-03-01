<?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b><br />
            <a href="logout.php">Выйти</a>
<?php } ?>

<?php if ($user == null) { ?>
            <a href="login.php">Войти</a>
            <br /><b>Вы не залогинены</b>
<?php } ?><br /><br />

<?php if (isset($_SESSION['login_success'])) { 
        echo '<span class="bold">' . $_SESSION['login_success'] . '</span>';
        $_SESSION['login_success'] = null;    
 } ?>

<?php if ($user == null) { ?>
<form action="login.php" method="post">
    <tr >
        <td>Логин: <br /><input class="login" type="text" name="login" /><br />
        </td>
        <td>Пароль:<br /> <input class="login" type="password" name="password" /><br />
        </td>
        <td><input type="checkbox" name="remember" /> Запомнить меня<br/>
        </td>
        <td><input type="submit" value="Залогиниться"/>
        </td>

    </tr>
</form>
<br />
<?php } ?>
<a href="index.php">Главная</a> <b>|</b> <a href="all_entries.php">Показать все</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a>
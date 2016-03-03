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
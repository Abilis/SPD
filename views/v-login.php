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
            <?php if ($user != null) { ?>
            <br />Вы вошли как <b><?=$user['login']?></b>
	           <?php } ?>
        </tr>
	</form>
<br />
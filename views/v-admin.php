Пользователи онлайн:

<?php foreach($whoUsersOnline as $userOnline) { ?>
    <b><?=$userOnline['login']?> </b>
<?php } ?>
<br />
<br />
<table>Сообщение дня <a href="#">[править]</a>
    <tr>
        <td>Какой-то текст
            <br /><span class="italic">Разместил <b>username</b> date</span>
        </td>
    </tr>    
</table>
<br />
Последние 10 событий: <a href="all_logs.php">Все логи</a>
<table>
    <tr>
        <th>Имя</th>
        <th>Действие</th>
        <th>Старая запись</th>
        <th>Новая запись</th>
        <th>Дата</th>
    </tr>
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<br />
<br />

Создать нового пользователя:
<form action="create_new_user.php" method="post">
    <label class="italic">Логин:</label><br />
    <input type="text" name="login"/><br>
    <label class="italic">Пароль:</label><br />
    <input type="password" name="password"/><br>
    <label class="italic">Повторите пароль:</label><br />
    <input type="password" name="confirmPassword"/><br>
    <label class="italic">Имя:</label><br />
    <input type="text" name="username"/><br>
    <label class="italic">Права:</label><br />   
    <label class="italic">Пользователь </label><input type=radio name="access" value="user" checked/> (Только просмотр)<br>
    <label class="italic">Оператор </label><input type=radio name="access" value="operator"/> (Плюс правка и добавление)<br>
    <label class="italic">Администратор</label><input type=radio name="access" value="administrator"/> (Плюс удаление и доступ сюда)<br>
    <label class="italic">Главный администратор</label><input type=radio name="access" value="mainAdministrator"/> (Плюс импорт в БД файлов .cvs)<br>
    <input type="submit" value="Создать"/>    
</form>
<br />
<b>Добавить сеть в БД с пометкой:</b>
<form action="#" method="post">
    <label>Метка адреса:</label><br />
    <input type="text" name="markAddress" value="Свободен" /><br />
    <label>Адрес сети (первый адрес):</label><br />
    <input type="text" name="network" /><br />
    <label>Префикс маски (например, /27):</label><br />
    <input type="text" name="netmask" value="/" /><br />
    <span class="bold">Шлюз будет отмечен как первый возможный адрес</span><br />
    <input type="submit"/>
</form>
<br />

<?php if ($canDoImportInDb) { ?>
<form action="#" method="post"><b>Добавить в БД данные .cvs</b><br />
    <label>Файл в формате .cvs в кодировке uft8</label><br>
    <input type="file" name="importCSV"/><br>
    <input type="submit" value="Импортировать!"/>
</form>
<?php } ?>
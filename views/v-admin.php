Пользователи онлайн:

<?php foreach($whoUsersOnline as $userOnline) { ?>
    <b><?=$userOnline['login']?> </b>
<?php } ?>
<br />
<br />
<table>Сообщение дня <a href="#">[править]</a>
    <tr>
        <td><?=$motd['text']?> <br /><br />
            Разместил <?='<b>' . $motd['autor'] . '</b> <i>' . $motd['dt_motd'] . '<i>'?>
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
    
    <?php for($i = 0; $i < 10; $i++) { //$i задает количество последних логов для отображения
    ?>
    <tr>
        <td><?=($i + 1) . '&nbsp;&nbsp;&nbsp;<b>' . $logs[$i]['login']?></b></td>
        <td><?=$logs[$i]['action']?></td>
        
        <td>
            <?php
                for ($j = 0; $j < 10; $j++) { //$j задает количество значимых полей. Они обозначены в functions.php
                echo '<b>' . $log_name[$j] . '</b>' . ': <span class="bold">' . $format_old_log[$i][$j] . '</span>; ';
            } ?>
                                     
        </td>
            
        <td>
            <?php
                for ($j = 0; $j < 10; $j++) {
                echo '<b>' . $log_name[$j] . '</b>' . ': <span class="bold">' . $format_new_log[$i][$j] . '</span>; ';
            } ?>
            
        </td>
        <td><?=$logs[$i]['dt_action']?></td>
    </tr>
    <?php } ?>
    
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
    <label>Влан:</label><br />
    <input type="text" name="vlan" /><br />
    <label>Терминация:</label><br />
    <input type="text" name="termination" /><br />    
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
Пользователи онлайн:

<?php foreach($whoUsersOnline as $userOnline) { ?>
    <b><?=$userOnline['login']?> </b>
<?php } ?>
<br />

<?php
if ($_SESSION['noAccessImportInDb']) ?>
    <span class="bold"><?=$_SESSION['noAccessImportInDb']?></span>
<?php
    $_SESSION['noAccessImportInDb'] = null;
?>

<?php
if ($_SESSION['networkGeneration']) ?>
    <span class="bold"><?=$_SESSION['networkGeneration']?></span>
<?php
    $_SESSION['networkGeneration'] = null;
?>

<?php
if ($_SESSION['CreateUser']) ?>
    <span class="bold"><?=$_SESSION['CreateUser']?></span>
<?php
    $_SESSION['CreateUser'] = null;
?>

<br />
<table>Сообщение дня <a href="admin.php?action=edit">[править]</a>
    <tr>
        <td><?=$motd['text']?> <br /><br />
            Разместил <?='<b>' . $motd['autor'] . '</b> <i>' . $motd['dt_motd'] . '<i>'?>
        </td>
    </tr>    
</table>
<br />
Последние 10 событий: (Всего логов: <?=$numLogs?> <b>|</b> <a href="all_logs.php">Все логи</a>)
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
Последние 10 действий: (Всего логов действий: <?=$numLogsAction?>)
<table>
    <tr>
        <th>Имя</th>
        <th>Действие</th>
        <th>Дата</th>
    </tr>
    
    <?php for($i = 0; $i < $numLogsActionInAdminPanel; $i++) { ?>
     <tr>
        <td>
            <?=$i + 1 . ".&nbsp;<b>" . $logsAction[$i]['login'] . '</b>'?>
        </td>
        <td>
            <?=$logsAction[$i]['message']?>
        </td>
        <td>
            <?=$logsAction[$i]['dt_action']?>
        </td>
    </tr>
    <?php } ?>

</table>
<br />

Создать нового пользователя:
<form action="users.php" method="post">
    <label class="italic">Логин:</label><br />
    <input type="text" name="login" value="<?=$login?>" /><br>
    <label class="italic">Пароль:</label><br />
    <input type="password" name="password"value="<?=$password?>" /><br>
    <label class="italic">Повторите пароль:</label><br />
    <input type="password" name="confirmPassword"value="<?=$comfirmPassword?>" /><br>
    <label class="italic">Имя:</label><br />
    <input type="text" name="username" value="<?=$username?>" /><br>
    <label class="italic">Права:</label><br />   
    <label class="italic">Пользователь </label><input type=radio name="access" value="accessUser" <?=$checkedAccessUser?> /> (Только просмотр)<br>
    <label class="italic">Оператор </label><input type=radio name="access" value="accessOperator" <?=$checkedAccessOperator?> /> (Плюс правка и добавление)<br>
    <label class="italic">Администратор</label><input type=radio name="access" value="accessAdministrator" <?=$checkedAccessAdministrator?> /> (Плюс удаление и доступ сюда)<br>
    
    <?php if ($canDoSuperusersControl) { ?>
    <label class="italic">Главный администратор</label><input type=radio name="access" value="accessMainAdministrator" <?=$checkedAccessMainAdministrator?>/> (Плюс импорт в БД файлов .cvs)<br>
    <?php } ?>
    
    <input type="submit" value="Создать"/>    
</form>

<br />

Список пользователей: (всего пользователей: <?=$numUsers?>, онлайн: <?=$numOnlineUsers?> 
                        (<?php foreach($whoUsersOnline as $userOnline) { ?>
                                    <b><?=$userOnline['login']?></b>
                        <?php } ?>))
<table class="viewUsers">
    <tr>
        <th><label>Пользователь</label>
        </th>
        <th><label>Права</label>       
        </th>
        <th><label>Имя</label>       
        </th>
    </tr>
    
    <?php foreach ($users as $user) { ?>
    
    <tr>
        <td><b><?=$user['login']?></b>
        </td>
        <td>
            <?php
             if ($user['id_role'] == 1) {
                echo 'Пользователь';
             }
             elseif ($user['id_role'] == 2) {
                echo 'Оператор';
             }
             elseif ($user['id_role'] == 5) {
                echo 'Администратор';
             }
             elseif ($user['id_role'] == 10) {
                echo 'Администратор';
             }             
    
            ?>
        </td>
        <td><?=$user['name']?>
        </td>
    </tr>
    
<?php } ?>
    
</table>

<br />
<b>Добавить сеть в БД с пометкой:</b>
<br />

<form action="admin.php" method="post">
    <label>Метка адреса:</label><br />
    <input type="text" name="markAddress" value="Свободен" /><br />
    <label>Адрес сети (первый адрес):</label><br />
    <input type="text" name="network" value="<?=$_POST['network']?>" /><br />
    <label>Бродкаст (последний адрес):</label><br />
    <input type="text" name="broadcast" value="<?=$_POST['broadcast']?>" /><br />
    <label>Влан:</label><br />
    <input type="text" name="vlan" value="<?=$_POST['vlan']?>" /><br />
    <label>Терминация:</label><br />
    <input type="text" name="termination" value="<?=$_POST['termination']?>" /><br />    
    <span class="bold">Шлюз будет отмечен как первый возможный адрес</span><br />
    <input type="submit"/>
</form>
<br />

<?php if (true) { ?>
<form action="./ss/excelToMysql.php" method="post" enctype="multipart/form-data"><b>Добавить в СПД данные .cvs</b><br />
    <label>Файл в формате .cvs в кодировке uft8</label>
    <input type="hidden" name="tableName" value="spd_table"/><br>
    <input type="file" name="filename"/><br>
    <input type="submit" value="Импортировать!"/>
</form>

<p>Первая строка в файле должна иметь заголовки следующего вида:<br />
    № договора = <i>numOrder</i>, Клиент = <i>customer</i>, Скорость = <i>tarif</i>, IP-адрес = <i>ip_address</i>,<br /> 
    Маска = <i>netmask</i>, Шлюз = <i>gateway</i>, Влан = <i>vlan_id</i>, Порт клиента = <i>customer_port</i>, <br />
    Терминация = <i>termination_point</i>, Подсеть = <i>subnet</i>, Бродкаст = <i>broadcast</i>, Комментарий = <i>commentary</i>, <br />
    Дата добавления = <i>dt_added</i>, Дата последней правки = <i>dt_last_edited</i> <br /><br />
    
    Допускается отсутствие одного или нескольких столбцов    
</p>
<?php } ?>
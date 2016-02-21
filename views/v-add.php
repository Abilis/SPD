<a href="index.php">Главная</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a>
<br />
<table id = "addTable">
    <tr>
        <th>№ дог</th>
        <th>Клиент</th>
        <th>Скорость</th>
        <th>IP-адрес</th>
        <th>Маска</th>
        <th>Шлюз</th>
        <th>Влан</th>
        <th>Порт клиента</th>
        <th>Терминация</th>
        <th>Отредактировано</th>
        <th>Комментарий</th>
    </tr>
    <form action="add.php" method="post">
        <tr>
            <td><input id="numOrderAdd" type="text" name="numOrder" />
            </td>
            <td><input type="text" name="customer"/> <br />
            </td>
            <td><input id="tarifAdd" type="text" name="tarif"/>
            </td>
            <td><input id="ip_addressAdd" type="text" name="ip_address" />
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <br />
        <input type="submit" value="Добавить" />
    </form>
    
    
</table>
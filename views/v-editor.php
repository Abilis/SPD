<a href="index.php">Главная</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a> <b>|</b> Найдено записей: <?=count($entries)?>
<table>
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
    
    <tr class="search">
        <td>
            <form action="search.php" method="post">
            <input id="numOrderSearch" type="text" name="numOrder"/> <br />
            <input id="numOrderSearchButton" type="submit" value="Поиск"/>
            
            </form>  
        </td>
        <td><form action="search.php" method="post">
            <input type="text" name="customer"/> <br />
            <input type="submit" value="Поиск"/>
            
            </form>        
        </td>
        <td></td>
        <td> 
            <form action="search.php" method="post">
            <input type="text" name="ip_address"/> <br />
            <input type="submit" value="Поиск"/>
            
            </form>   
        </td>
        <td></td>
        <td></td>
        <td>
            <form action="search.php" method="post">
            <input id="vlan_id" type="text" name="vlan_id"/> <br />
            <input type="submit" value="Поиск"/>
            
            </form>         
        </td>
        <td></td>
        <td></td>
        <td>
            <form action="search.php" method="post">
            <input type="text" name="last_editor"/> <br />
            <input type="submit" value="Поиск"/>
            
            </form>   
        </td>
        <td></td>
    </tr>
    
    <?php if (empty($entries)) { ?>
    <tr>
        <td colspan="11" id="nothingSearch">Ничего не найдено!</td>
    </tr>
    <?php
    die();
    } 
    

    ?>
    
    
    
    <?php foreach ($entries as $entry): ?>
        <tr>
            <td><?=$entry['numOrder']?></td>
            <td><?=$entry['customer']?> <br />
                <span class="small">
                    <a href="editor.php?id=<?=$entry['id_entry']?>&action=edit"><править></a>
                </span>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span class="small">
                        <a href="editor.php?id=<?=$entry['id_entry']?>&action=delete"><удалить></a>
                    </span>
            </td>
            <td><?=$entry['tarif']?></td>
            <td><?=$entry['ip_address']?></td>
            <td><?=$entry['netmask']?></td>
            <td><?=$entry['gateway']?></td>
            <td><?=$entry['vlan_id']?></td>
            <td><?=$entry['customer_port']?></td>
            <td><?=$entry['termination_point']?></td>
            <td><?=$entry['dt_last_edited'] . ' by ' . $entry['last_editor'] ?></td>
            <td><?=$entry['commentary']?></td>
            
        </tr>
    <?php endforeach ?>

</table>
<?php
//var_dump($entries);
?>
<a href="index.php">Главная</a> <b>|</b> <a href="editor.php">Редактировать записи</a> <b>|</b> <a href="add.php">Добавить клиента</a>
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
    
    <?php foreach ($entries as $entry): ?>
        <tr>
            <td><?=$entry['numOrder']?></td>
            <td><?=$entry['customer']?></td>
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

<?php
  
    //Проверяем, нужны ли стрелки назад
    if ($page != 1) { 
        $pervpage = '<a href= ./index.php?page=1><<</a> <a href= ./index.php?page=' . ($page - 1) . '><</a> ';
    }
                
    // Проверяем нужны ли стрелки вперед 
    if ($page != $total) {
        $nextpage = ' <a href= ./index.php?page=' . ($page + 1) . '>></a> <a href= ./index.php?page=' . $total . '>>></a>';
    }
                

    // Находим две ближайшие станицы с обоих краев, если они есть 
    if ($page - 2 > 0) {
        $page2left = ' <a href= ./index.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
    }
                
    if ($page - 1 > 0) {
        $page1left = '<a href= ./index.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';}
                
    if ($page + 2 <= $total) {
        $page2right = ' | <a href= ./index.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
    }
                
    if ($page + 1 <= $total) {
        $page1right = ' | <a href= ./index.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';
     }

    
    // Вывод меню 
    echo $pervpage . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $nextpage; 

?>
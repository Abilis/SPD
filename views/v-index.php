<table>
    <tr class="color1">
        <th>№ дог</th>
        <th>Клиент</th>
        <th>Скорость</th>
        <th>IP-адрес</th>
        <th>Маска</th>
        <th>Шлюз</th>
        <th>
            <form action="search.php" method="post">                
                <input type="submit" name="sortedByVlan" value="Влан" />
            </form>
        </th>
        <th>Порт клиента</th>
        <th>Терминация</th>
        <th>Комментарий</th>
        <th>Отредактировано</th>
    </tr>
    
    <tr class="search">
        <td>
            <form action="search.php" method="post">
                <input id="numOrderSearch" type="search" name="numOrder"/> <br />
                <input id="numOrderSearchButton" type="submit" value="Поиск"/>
            </form>  
        </td>
        <td><form action="search.php" method="post">
                <input type="search" name="customer"/> <br />
                <input type="submit" value="Поиск"/>            
            </form>        
        </td>
        <td></td>
        <td> 
            <form action="search.php" method="post">
                <input type="search" name="ip_address"/> <br />
                <input type="submit" value="Поиск"/>            
            </form>   
        </td>
        <td></td>
        <td></td>
        <td>
            <form action="search.php" method="post">
                <input id="vlan_id" type="search" name="vlan_id"/> <br />
                <input type="submit" value="Поиск"/>
            </form>         
        </td>
        <td></td>
        <td></td>
        <td>
            <form action="search.php" method="post">
                <input type="search" name="commentary"/> <br />
                <input type="submit" value="Поиск"/>
            </form> 
        </td>
        <td>
            <form action="search.php" method="post">
                <input type="search" name="last_editor"/> <br />
                <input type="submit" value="Поиск"/>
            </form>   
        </td>        
    </tr>
    
    <?php if (empty($entries)) { ?>
    <tr>
        <td colspan="11" id="nothingSearch">Ничего не найдено!</td>
    </tr>
    <?php
    die();
    } ?>
    
    <?php for ($i = 0; $i < count($entries); $i++) { ?>        
    
        <tr <?php if ($i % 2 == 0) echo 'class="color1"'; else echo 'class="color2"';?>>
            <td> <?=$entries[$i]['numOrder']?> </td>
            <td <?php if (is_int(stripos($entries[$i]['customer'], 'вобод'))) { echo  'class="free"'; } ?> > <?=$entries[$i]['customer']?> <br />
                
                <?php if ($canDoEdit) { ?>
                    <span class="small">
                        <a href="index.php?id_entry=<?=$entries[$i]['id_entry']?>&action=edit">[править]</a>
                    </span>
                <?php } ?>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    
                <?php if ($canDoDelete) { ?>
                    <span class="small">
                        <a href="index.php?id_entry=<?=$entries[$i]['id_entry']?>&action=delete" onClick="return window.confirm('Вы действительно хотите удалить эту запись?')">[удалить]</a>
                    </span>
                 <?php } ?>
                        
            </td>
            <td><?=$entries[$i]['tarif']?></td>
            <td><?=$entries[$i]['ip_address']?></td>
            <td><?=$entries[$i]['netmask']?></td>
            <td><?=$entries[$i]['gateway']?></td>
            <td><?=$entries[$i]['vlan_id']?></td>
            <td><?=$entries[$i]['customer_port']?></td>
            <td><?=$entries[$i]['termination_point']?></td>
            <td><?=$entries[$i]['commentary']?></td>
            <td><?=$entries[$i]['dt_last_edited'] . ' by ' . $entries[$i]['last_editor'] ?></td>
                        
        </tr>
    <?php } ?>

</table>
<?php
        if ($_SESSION['deleteOldLogs']) {
            echo '<span class="bold">' . $_SESSION['deleteOldLogs'] . ' </span>';
            $_SESSION['deleteOldLogs'] = null;
        }    
    ?>
Всего логов: <?=$numLogs?>
<table>
    <tr>
        <th>Имя</th>
        <th>Действие</th>
        <th>Старая запись</th>
        <th>Новая запись</th>
        <th>Дата</th>
    </tr>
    
    <?php for($i = 0; $i < $num_rows; $i++) { //$i задает количество последних логов для отображения
    
 //   var_dump($format_old_log);
 //   die();
    
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
<form class="deleteOldLogs" action="all_logs.php" method="post">
    <label>Удалить логи, старше 3 месяцев</label>
    <input type="submit" name="deleteOldLogs" value="Выполнить!"/>    
</form>
<br />
<?php
  
    //Проверяем, нужны ли стрелки назад
    if ($page != 1) { 
        $pervpage = '<a href= ./index.php?page=1>В начало</a>' . ' | ' . '<a href= ./index.php?page=' . ($page - 1) . '>Назад</a> ' . ' | ';
    }
                
    // Проверяем нужны ли стрелки вперед 
    if ($page != $total) {
        $nextpage = ' | ' . '<a href= ./index.php?page=' . ($page + 1) . '>Вперед</a>' . ' | ' . '<a href= ./index.php?page=' . $total . '>В конец</a>';
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
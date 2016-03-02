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
        
        <th>Комментарий</th>
    </tr>
    <form action="index.php" method="post">
        <tr>
            <td><input id="addNumOrder" class="addForm" type="text" name="numOrder" value="<?=$numOrder?>" /> <br />
                <div class="italic">Рек.</div>
            </td>
            <td><input class="addForm" type="text" name="customer" value="<?=$customer?>"/> <br />
                <div class="bold">Обязательное поле!</div>
            </td>
            <td><input class="addForm" type="text" name="tarif" value="<?=$tarif?>"/> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
            <td><input class="addForm" type="text" name="ip_address" value="<?=$ip_address?>"/> <br />
                <div class="bold">Обязательное поле!</div>
            </td>
            <td><input class="addForm" type="text" name="netmask" value="<?=$netmask?>"/> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
            <td><input class="addForm" type="text" name="gateway" value="<?=$gateway?>"/> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
            <td><input id="addVlanId" class="addForm" type="text" name="vlan_id" value="<?=$vlan_id?>"/> <br />
                <div class="bold">Обяз!</div>
            </td>
            <td><input class="addForm" type="text" name="customer_port" value="<?=$customer_port?>"/> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
            <td><input class="addForm" type="text" name="termination_point" value="<?=$termination_point?>"/> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
            
            <td><textarea id="addCommentary" class="addForm" type="text" name="commentary" rows="4"><?=$commentary?></textarea> <br />
                <div class="italic">Рекомендуется к заполнению</div>
            </td>
        </tr>
        <br />
        <input type="hidden" name="id_entry" value="<?=$id_entry?>" />
        <input type="submit" value="Отредактировать" />
    </form>
    
    
</table>
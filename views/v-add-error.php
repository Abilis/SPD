<?php if ($user == null) {?>
<br />
<br />
    <span class="addError">Только зарегистрированные пользователи могут добавлять записи!</span>
<br />
<?php } ?>

<?php if (!$canDoAdd && $user != null) {?>
<br />
<br />
    <span class="addError">Недостаточно прав для добавления записей!</span>
<br />
<?php } ?>
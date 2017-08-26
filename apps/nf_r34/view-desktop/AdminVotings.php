<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetAdminVotings');

CheckAdminAccess();
$data = GetAdminVotings();

ViewHtmlTop("Управление голосованиями");
ViewHeader();
//var_dump($data);die;
?>
<div>
<form method="POST" action="<?=$script?>?c=EditAdminVotings">
<table>
<thead><tr><td>x</td><td>Голосование</td><td>Обновить</td></tr></thead>
<tbody>
<?php if($data): ?>
<?php foreach($data as $vs): ?>
<tr>
    <td><input type="checkbox" name="d[<?=$vs['id']?>]" /></td>
    <td>
    vote_id: <?=$vs['id']?> <br /><br />
    <input type="text" name="name[<?=$vs['id']?>]" size="66" placeholder="Заглавие голосования" value="<?=addslashes($vs['name'])?>" /><br />
    <textarea name="desc[<?=$vs['id']?>]" rows="7" cols="75" placeholder="Описание голосования"><?=addslashes($vs['descript'])?></textarea><br />
    <br />
    <table>
    <thead>
    <tr><td>x</td><td>Выбор</td><td>Обновить</td></tr>
    </thead>
    <tbody>
<?php foreach($vs['chooses'] as $choose): ?>
    <tr>
    <td><input type="checkbox" name="cd[<?=$choose['id']?>]" /></td>
    <td><input type="text" name="choose[<?=$choose['id']?>]" value="<?=$choose['choose']?>" /></td>
    <td><input type="checkbox" name="ce[<?=$choose['id']?>]" /></td>
    </tr>
<?php endforeach; ?>
    <tr>
    <td colspan="3">Добавить: <input type="text" name="add_c[<?=$vs['id']?>]" /></td>
    </tr>
    </tbody>
    </table>
    <br />
    <input type="checkbox" name="mult[<?=$vs['id']?>]" <?= $vs['mult'] ? 'checked ' : '' ?>/> Множественный выбор <br />
    <input type="checkbox" name="active[<?=$vs['id']?>]" <?= $vs['active'] ? 'checked ' : '' ?>/> Активное голосование
    </td>
    <td><input type="checkbox" name="e[<?=$vs['id']?>]" /></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
<tr><td colspan="3">Добавить записей: <input type="text" name="add" /></td></tr>
<tr><td colspan="3"><input type="submit" class="go" value="Отправить" /></td></tr>
</tbody>
</table>
</form>
</div>
</div>
</body>
</html>
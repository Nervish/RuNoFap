<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetId');
Model('GetFails');

CheckAdminAccess();

?>
<?php if(isset($_GET['target']) and !empty($_GET['target'])): ?>
<?php $udata = GetId($_GET['target']); ?>
<?php if($udata): ?>
<?php
ViewHtmlTop("Изменение записи", 'AdminEdit.css');
ViewHeader();
?>

<form id="f" method="POST" action="<?=$script?>?c=EditNote"></form>
<input form="f" class="acc-edit__input" name="orig_email" type="text" value="<?=$udata['email']?>" hidden />
<div class="wrapper">
  <div class="acc-edit">
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update acc-edit__update_head">Обновить</div>
      <div class="acc-edit__element acc-edit__name acc-edit__name_head">Поле</div>
      <div class="acc-edit__element acc-edit__field acc-edit__field_head">Значение</div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"><input form="f" type="checkbox" name="cn" /></div>
      <div class="acc-edit__element acc-edit__name">nick</div>
      <div class="acc-edit__element acc-edit__field"><input form="f" class="acc-edit__input" name="nick" type="text" value="<?=$udata['nick']?>" /></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"><input form="f" type="checkbox" name="ce" /></div>
      <div class="acc-edit__element acc-edit__name">email</div>
      <div class="acc-edit__element acc-edit__field"><input form="f" class="acc-edit__input" name="email" type="text" value="<?=$udata['email']?>" /></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"><input form="f" type="checkbox" name="cr" /></div>
      <div class="acc-edit__element acc-edit__name">refresh</div>
      <div class="acc-edit__element acc-edit__field"><input form="f" class="acc-edit__input" name="refresh" type="text" value="<?=date("d.m.Y H:i:s", $udata['refresh'])?>" /></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"><input form="f" type="checkbox" name="ct" /></div>
      <div class="acc-edit__element acc-edit__name">time</div>
      <div class="acc-edit__element acc-edit__field"><input form="f" class="acc-edit__input" name="time" type="text" value="<?=date("d.m.Y H:i:s", $udata['time'])?>" /></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"></div>
      <div class="acc-edit__element acc-edit__name">fails</div>
      <div class="acc-edit__element acc-edit__field"><?=GetFails($udata['email'])['all']?></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"></div>
      <div class="acc-edit__element acc-edit__name">army</div>
      <div class="acc-edit__element acc-edit__field"><?=$udata['army']?></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"></div>
      <div class="acc-edit__element acc-edit__name">ip_hash</div>
      <div class="acc-edit__element acc-edit__field"><a class="link" href="<?=$script?>?v=AdminAccountList&sort=time&ip=<?=$udata['ip_hash']?>"><?=$udata['ip_hash']?></a></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__update"></div>
      <div class="acc-edit__element acc-edit__name">c_time</div>
      <div class="acc-edit__element acc-edit__field"><?=date("d.m.Y H:i:s", $udata['c_time'])?></div>
    </div>
    <div class="acc-edit__row">
      <div class="acc-edit__element acc-edit__full">
        <input form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

</main>
</body>
</html>
<?php else: ?>
<?php ViewErrorPage("Запись с таким email не найдена!"); ?>
<?php endif; ?>
<?php else: ?>
<?php ViewErrorPage("Email не задан!"); ?>
<?php endif; ?>
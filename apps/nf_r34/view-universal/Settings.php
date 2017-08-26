<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetEmail');

$udata = Auth();

if($udata['allow_diary_comments']) {
    $c1 = 'selected="selected" ';
    $c2 = '';
}
else{
    $c1 = '';
    $c2 = 'selected="selected" ';
}
$udata['allow_diary_comments'] ? $c = 'checked ' : $c = '';

ViewHtmlTop("Настройки", 'Settings.css');
ViewHeader();

?>
<form method="POST" name="f" action = "<?=$script?>?c=Settings">
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Настройки</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">Система рангов
        <select name="rank_system" size="1">
<?php foreach($GLOBALS['rank_systems'] as $key=>$rs): ?>
<?php if($udata['rank_system'] == $key): ?>
          <option selected="selected" value="<?=$key?>"><?=$rs?></option>
<?php else: ?>
          <option value="<?=$key?>"><?=$rs?></option>
<?php endif; ?>
<?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">Комментарии в дневнике
        <select name="allow_diary_comments" size="1">
          <option <?=$c1?>value="allow">Разрешены</option>
          <option <?=$c2?>value="disallow">Запрещены</option>
        </select>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" type="submit" value="Изменить настройки" />
      </div>
    </div>
  </div>
</div>
</main>
</body>
</html>
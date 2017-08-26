<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetData');

CheckAdminAccess();

$data = GetData("One", "Links");

ViewHtmlTop("Изменение ссылок", 'AdminEditLinks.css');
ViewHeader();

?>

<form id="f" method="POST" action="<?=$script?>?c=AdminEditLinks"></form>
<div class="wrapper">
  <div class="links-files">
    <div class="links-files__row">
      <div class="links-files__element links-files__element_remove links-files__element_remove_head">Удалить</div>
      <div class="links-files__element links-files__element_item links-files__element_item_head">Ссылка</div>
      <div class="links-files__element links-files__element_comment links-files__element_comment_head">Комментарий</div>
    </div>
<?php $c = 0; ?>
<?php foreach($data[0]['links'] as $link): ?>
    <div class="links-files__row">
      <div class="links-files__element links-files__element_remove">
        <input form="f" type="checkbox" name="d[<?=$c?>]" />
      </div>
      <div class="links-files__element links-files__element_item">
        <input class="links-files__input" form="f" type="text" name="link[<?=$c?>]" value="<?=addslashes($link['link'])?>" />
      </div>
      <div class="links-files__element links-files__element_comment">
        <textarea class="links-files__input" form="f" name="text[<?=$c?>]" rows="5"><?=addslashes($link['text'])?></textarea>
      </div>
    </div>
<?php $c++; ?>
<?php endforeach; ?>
    <div class="links-files__row">
      <div class="links-files__element links-files__element_full">
        <input class="links-files__input" form="f" type="text" name="add" placeholder="Добавить записей:" />
      </div>
    </div>
    <div class="links-files__row">
      <div class="links-files__element links-files__element_full">
        <input form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

</main>
</body>
</html>
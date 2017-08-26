<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetFiles');

CheckAdminAccess();

$files = GetFiles($GLOBALS['files_dir']);
ViewHtmlTop("Изменение файлов", 'AdminEditFiles.css');
ViewHeader();

?>

<form id="f" method="POST" enctype="multipart/form-data" action="<?=$script?>?c=AdminEditFiles"></form>
<div class="wrapper">
  <div class="links-files">
    <div class="links-files__row">
      <div class="links-files__element links-files__element_remove links-files__element_remove_head">Удалить</div>
      <div class="links-files__element links-files__element_item links-files__element_item_head">Файл</div>
      <div class="links-files__element links-files__element_comment links-files__element_comment_head">Комментарий</div>
    </div>
<?php $c = 0; ?>
<?php foreach($files as $file): ?>
    <div class="links-files__row">
      <div class="links-files__element links-files__element_remove">
        <input form="f" type="checkbox" name="d[<?=$c?>]" />
      </div>
      <div class="links-files__element links-files__element_item">
        <input class="links-files__input" form="f" type="text" name="file[<?=$c?>]" value="<?=addslashes($file[1])?>" readonly />
      </div>
      <div class="links-files__element links-files__element_comment">
        <textarea class="links-files__input" form="f" name="text[<?=$c?>]" rows="5"><?=addslashes($file[2])?></textarea>
      </div>
    </div>
<?php $c++; ?>
<?php endforeach; ?>
    <div class="links-files__row">
      <div class="links-files__element links-files__element_full">
        <input form="f" type="hidden" name="MAX_FILE_SIZE" value="100000000" />
        <input form="f" type="file" name="files" multiple />
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
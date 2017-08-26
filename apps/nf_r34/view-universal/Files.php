<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetFiles');

ViewHtmlTop("Файлы", 'Files.css');
ViewHeader();

$files = GetFiles($GLOBALS['files_dir']);

?>
<div class="wrapper">
  <div class="list-container size_360p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Файлы</div>
    </div>
<?php foreach($files as $file): ?>
    <div class="list-container__row">
      <div class="list-container__element list-container__text">
        <a class="link" href="<?=$file[0]?>"><?=$file[1]?></a><br />
<?=$file[2]?>
      </div>
    </div>
<?php endforeach; ?>
  </div>
</div>
</main>
</body>
</html>
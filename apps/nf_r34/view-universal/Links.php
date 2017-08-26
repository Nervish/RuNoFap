<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetData');

ViewHtmlTop("Ссылки", 'Links.css');
ViewHeader();

$data = GetData("One", "Links");

?>
<div class="wrapper">
  <div class="list-container size_540p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Ссылки</div>
    </div>
<?php foreach($data[0]['links'] as $link): ?>
    <div class="list-container__row">
      <div class="list-container__element list-container__text">
        <a class="link" href="<?=$link['link']?>">[Ссылка]</a><br />
<?=$link['text']?>
      </div>
    </div>
<?php endforeach; ?>
</div>
</main>
</body>
</html>
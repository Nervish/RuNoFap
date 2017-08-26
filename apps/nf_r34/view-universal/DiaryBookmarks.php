<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetDiaryBookmarks');

$udata = Auth();
$list = GetDiaryBookmarks($udata['id']);

ViewHtmlTop("Список избранных дневников", 'DiaryBookmarks.css');
ViewHeader();

?>
<div class="wrapper">
<?php if($list): ?>
  <div class="list-container size_420p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Избранные дневники</div>
    </div>
<?php foreach($list as $var): ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=Diary&for=<?=$var['diary_link']?>"><?=$var['nick']?></a> (<?=$var['days']?> дн.)
      </div>
    </div>
<?php endforeach; ?>
  </div>
<?php else: ?>
Нет избранных дневников.
<?php endif; ?>
</div>
</main>
</body>
</html>
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetTopic');

Resource('MixedMark.php');

CheckAdminAccess();

if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0) {
    $topic = GetTopic($_GET['id']);
}
else{
    ViewErrorPage("Неправильный идентификатор поста!");
}

if(!$topic) {
    ViewErrorPage("Пост не найден!");
}
$now = time();

ViewHtmlTop('Удаление поста', 'ForumDelete.css');
ViewHeader();

?>

<div class="wrapper wrapper_text">
  <a class="link" href="<?=$script?>?c=DeleteForumPost&id=<?=$_GET['id']?>">Удалить пост</a>
</div>

<div class="posts-wrapper">
<div class="post">
  <div class="post__info">
<?php if($topic['nick'] == 'Гость'): ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="#guest"><?=$topic['nick']?></a>
    </div>
<?php else: ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="<?=$script?>?v=Diary&for=<?=$topic['author_id']?>"><?=$topic['nick']?></a>
      <div class="post__date"><?=date("d.m.Y H:i", strtotime($topic['time']))?></div>
    </div>
<?php if(isset($_SESSION['admin'])): ?>
    <div class="post-options-wrapper">
      <a class="post__option post__option--admin" href="<?=$script?>?v=AdminEdit&target=<?=$topic['author_id']?>">[▲]</a>
    </div>
<?php endif; ?>
<?php endif; ?>
  </div>
  <div class="post__content">
    <div class="post__text"><?=nl2br(MixedMark($topic['post']))?></div>
  </div>
</div>
</div>

</main>
</body>
</html>
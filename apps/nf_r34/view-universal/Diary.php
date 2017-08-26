<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetDiaryPages');
Model('GetDiaryTopics');
Model('GetEmail');
Model('GetDiaryBookmarks');
Model('GetNoFapArmies');
Model('GetWar');

Resource('MixedMark.php');

if(isset($_GET['for']) and !empty($_GET['for']) and is_numeric($_GET['for']) and $_GET['for'] > 0) {
    $for = $_GET['for'];
}
else{
    $for = 0;
}
$public = true;

if(isset($_SESSION['auth']) and $_SESSION['auth']) {
    $udata = GetEmail($_SESSION['email']);
    if($for == $udata['id']) {
        $public = false;
    }
}

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

if(isset($_GET['df']) && is_numeric($_GET['df']) && $_GET['df'] > 0)
    $df = $_GET['df'];
else
    $df = 0;

$pages = ceil(GetDiaryPages($for, $df, $public)/$GLOBALS['per_page_4diary']);
$list = GetDiaryTopics($for, ($page-1)*$GLOBALS['per_page_4diary'], $GLOBALS['per_page_4diary'], $df, $public);
$war = GetWar();
$armies = GetNoFapArmies();
$now = time();

$arms = array();
foreach($armies as $army) {
    $arms[$army['name']] = $army;
}

if($war and $war['start'] < $now and $war['finish'] > $now) {
    $iswar = true;
}
else{
    $iswar = false;
}

ViewHtmlTop('Дневник', 'Diary.css');
ViewHeader();

?>

<?php Resource('ArmyStyles.php'); ?>

<?php if(!$public): ?>
<form method="POST" id="f" action="<?=$script?>?c=Diary">
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Добавить запись</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="f" name="note" rows="12" placeholder="Текст записи"></textarea>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input form="f" name="public" type="checkbox" />Публичная запись
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
<?php if($for and $public and isset($udata)): ?>
<div class="wrapper wrapper_text">
<?php if(GetDiaryBookmarks($udata['id'], $for)): ?>
  <a class="link" href="<?=$script?>?c=DiaryBookmarks&d=delete&for=<?=$for?>" title="Удалить дневник из закладок">[Удалить дневник из закладок]</a>
<?php else: ?>
  <a class="link" href="<?=$script?>?c=DiaryBookmarks&d=add&for=<?=$for?>" title="Добавить дневник в закладки">[Добавить дневник в закладки]</a>
<?php endif; ?>
</div>
<?php endif; ?>

<?php if($list['list']): ?>
<div class="wrapper wrapper_text">
  <a class="link" name="top" href="#bottom">[Вниз]</a>
</div>

<form method="GET" action="<?=$script?>">
<div class="wrapper">
  Минимум дней: 
  <input type="text" name="df" value="<?=$df?>" />
  <input type="submit" value="Ок" />
</div>
</form>

<div class="posts-wrapper">
<?php foreach($list['list'] as $var): ?>

<?php 
    if($var['refresh'] < $now-$GLOBALS['days']*(3600*24)) $mark = " post__streak_inactive";
    else $mark = "";
?>
<div class="post">
  <div class="post__info">
<?php if(!$var['c_time']): ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="#guest"><?=$var['nick']?></a>
    </div>
<?php else: ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="<?=$script?>?v=Diary&for=<?=$var['author_id']?>"><?=$var['nick']?></a>
<?php if($iswar and $var['army'] != 'empty' and $var['army'] != 'enter'): ?>
<?php
$code = '';
if(!empty($list['warrior_statuses'][$var['author_id']])) {
    $status = $list['warrior_statuses'][$var['author_id']];
    if($status == 'lose') {
        $code = '-dead';
    }
    elseif($status == 'lost') {
        $code = '-dead';
    }
}
else{
    if($var['ntime'] >= $war['start']) {
        $code = '-dead';
    }
}
?>
    <div class="post__flair post__flair--army<?=$arms[$var['army']]['id'].$code?>"><?=$var['army']?></div>
<?php endif; ?>
      <div class="post__streak<?=$mark?>"><?=floor(($now-$var['ntime'])/(3600*24))?> дн.</div>
    </div>
<?php endif; ?>
    <div class="post__date"><?=date("d.m.Y H:i", strtotime($var['time']))?></div>
    <div class="post-options-wrapper">
<?php if(isset($_SESSION['admin']) and $_SESSION['admin']): ?>
      <a class="post__option post__option--admin" href="<?=$script?>?v=AdminEdit&target=<?=$var['author_id']?>">[▲]</a>
<?php endif; ?>
<?php if(!$public): ?>
      <a class="post__option" href="<?=$script?>?c=DiaryDeleteNote&id=<?=$var['id']?>" title="Удалить запись">Удалить</a>
<?php if($var['public']): ?>
      <a class="post__option" href="<?=$script?>?c=EditDiary&id=<?=$var['id']?>&d=hide" title="Скрыть запись от посторонних">Скрыть</a>
<?php else: ?>
      <a class="post__option" href="<?=$script?>?c=EditDiary&id=<?=$var['id']?>&d=show" title="Сделать запись доступной для просмотра">Показать</a>
<?php endif; ?>
<?php endif; ?>
      <a class="post__option" href="<?=$script?>?v=DiaryAnswer&id=<?=$var['id']?>">Ответить</a>
    </div>
  </div>
  <div class="post__content">
    <div class="post__text"><?=nl2br(MixedMark($var['note']))?></div>
  </div>
</div>

<?php foreach($var['comments'] as $var): ?>
<?php 
    if($var['refresh'] < $now-$GLOBALS['days']*(3600*24)) $mark = " post__streak_inactive";
    else $mark = "";
?>
<div class="post post--reply-1lvl">
  <div class="post__info">
<?php if(!$var['c_time']): ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="#guest"><?=$var['nick']?></a>
    </div>
<?php else: ?>
    <div class="post__author-wrapper">
      <a class="post__author" href="<?=$script?>?v=Diary&for=<?=$var['author_id']?>"><?=$var['nick']?></a>
<?php if($iswar and $var['army'] != 'empty' and $var['army'] != 'enter'): ?>
<?php
$code = '';
if(!empty($list['warrior_statuses'][$var['author_id']])) {
    $status = $list['warrior_statuses'][$var['author_id']];
    if($status == 'lose') {
        $code = '-dead';
    }
    elseif($status == 'lost') {
        $code = '-dead';
    }
}
else{
    if($var['ntime'] >= $war['start']) {
        $code = '-dead';
    }
}
?>
    <div class="post__flair post__flair--army<?=$arms[$var['army']]['id'].$code?>"><?=$var['army']?></div>
<?php endif; ?>
      <div class="post__streak<?=$mark?>"><?=floor(($now-$var['ntime'])/(3600*24))?> дн.</div>
    </div>
<?php endif; ?>
    <div class="post__date"><?=date("d.m.Y H:i", strtotime($var['time']))?></div>
    <div class="post-options-wrapper">
<?php if(isset($_SESSION['admin']) and $_SESSION['admin']): ?>
      <a class="post__option post__option--admin" href="<?=$script?>?v=AdminEdit&target=<?=$var['author_id']?>">[▲]</a>
<?php endif; ?>
<?php if(!$public): ?>
      <a class="post__option" href="<?=$script?>?c=DiaryDeleteNote&id=<?=$var['id']?>" title="Удалить запись">Удалить</a>
<?php endif; ?>
    </div>
  </div>
  <div class="post__content">
    <div class="post__text"><?=nl2br(MixedMark($var['note']))?></div>
  </div>
</div>

<?php endforeach; ?>
<?php endforeach; ?>
</div>

<div class="wrapper wrapper_text">
  <a class="link" name="bottom" href="#top">[Вверх]</a>
</div>
<?php else: ?>
<div class="wrapper">В дневнике нет записей.</div>
<?php endif; ?>

<?php
Resource("Paginator.php");
Paginator("Diary", $page, $pages, "for=$for&df=$df");
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden post__streak_inactive"></div>-->
<!--<div class="code quote spoiler"></div>-->
</main>
</body>
</html>
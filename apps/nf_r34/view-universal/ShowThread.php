<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetThreadPages');
Model('GetThreadTopics');
Model('GetNoFapArmies');
Model('GetWar');

Resource('MixedMark.php');

if(isset($_GET['thread']) && is_numeric($_GET['thread']) && $_GET['thread'] > 0)
    $thread = $_GET['thread'];
else
    ViewErrorPage("Номер треда не указан!");

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

$pages = ceil(GetThreadPages($thread)/$GLOBALS['per_page_4thread']);
$list = GetThreadTopics($thread, ($page-1)*$GLOBALS['per_page_4thread'], $GLOBALS['per_page_4thread']);
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

ViewHtmlTop($list['subject'], 'ShowThread.css');
ViewHeader();

?>

<?php Resource('ArmyStyles.php'); ?>

<?php if($list): ?>
<div class="wrapper wrapper_text">
  <a class="link" name="top" href="#bottom">[Вниз]</a>
</div>
<?php endif; ?>

<?php if($list): ?>
<div class="posts-wrapper">
<?php foreach($list['list'] as $var): ?>

<?php 
    if($var['refresh'] < $now-$GLOBALS['days']*(3600*24)) $mark = " post__streak_inactive";
    else $mark = "";
?>
<div class="post">
  <a name="<?=$var['num']?>"></a>
  <div class="post__info">
    <div class="post__number">#<?=$var['num']?></div>
<?php if(!$var['c_time']): ?>
    <div class="post__author-wrapper"><a class="post__author" href="#this"><?=$var['nick']?></a>
    </div>
<?php else: ?>
    <div class="post__author-wrapper"><a class="post__author" href="<?=$script?>?v=Diary&for=<?=$var['author_id']?>"><?=$var['nick']?></a>
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
<?php if(isset($_SESSION['admin']) and $_SESSION['admin']): ?>
      <div class="post-options-wrapper">
        <a class="post__option post__option--admin" href="<?=$script?>?v=AdminEdit&target=<?=$var['author_id']?>">[▲]</a>
        <a class="post__option" href="<?=$script?>?v=ForumDelete&id=<?=$var['id']?>" title="Удалить запись">Удалить</a>
      </div>
<?php endif; ?>
  </div>
  <div class="post__content">
    <div class="post__title"><?=$var['subject']?></div>
    <div class="post__text"><?=nl2br(MixedMark($var['post']))?></div>
  </div>
</div>

<?php endforeach; ?>
<?php endif; ?>
</div>

<?php if($list): ?>
<div class="wrapper wrapper_text">
  <a class="link" name="bottom" href="#top">[Вверх]</a>
</div>
<?php endif; ?>

<?php
Resource("Paginator.php");
Paginator("ShowThread", $page, $pages, "thread=".$list['id']);
?>

<form id="f" method="POST" action="<?=$script?>?c=ForumPost"></form>
<input form="f" type="text" name="to" value="<?=$thread?>" hidden />
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Написать сообщение</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="subject" placeholder="Тема" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="f" name="post" rows="9" placeholder="Текст сообщения"></textarea>
      </div>
    </div>
<?php if($GLOBALS['forum_captcha'] or ! (isset($_SESSION['auth']) and $_SESSION['auth']) ): ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="captcha" placeholder="Капча" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <img src="captcha.php">
      </div>
    </div>
<?php endif; ?>
<?php if($list['war_thread']): ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input form="f" type="radio" name="false_nick" value="spy" />Разведчик
      </div>
      <div class="list-container__element">
        <input form="f" type="radio" name="false_nick" value="diversant" />Диверсант
      </div>
    </div>
<?php endif; ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>
<!--<div class="code quote spoiler"></div>-->
<!--<div class="navigation__paginator navigation__link navigation__hidden post__streak_inactive"></div>-->
</main>
</body>
</html>
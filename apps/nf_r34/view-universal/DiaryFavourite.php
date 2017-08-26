<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetDiaryFavouritePages');
Model('GetDiaryFavourite');
Model('GetNoFapArmies');
Model('GetWar');
Model('Auth');

Resource('MixedMark.php');

$udata = Auth();

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;
    
if(isset($_GET['df']) && is_numeric($_GET['df']) && $_GET['df'] > 0)
    $df = $_GET['df'];
else
    $df = 0;

$pages = ceil(GetDiaryFavouritePages($udata['id'], $df)/$GLOBALS['per_page_4diary']);
$list = GetDiaryFavourite($udata['id'], ($page-1)*$GLOBALS['per_page_4diary'], $GLOBALS['per_page_4diary'], $df);
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

ViewHtmlTop('Избранные дневники', 'DiaryFavourite.css');
ViewHeader();

?>

<?php Resource('ArmyStyles.php'); ?>

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
<div class="wrapper">В избранных дневниках нет записей.</div>
<?php endif; ?>

<?php
Resource("Paginator.php");
Paginator("DiaryFavourite", $page, $pages, "df=$df");
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden post__streak_inactive"></div>-->
<!--<div class="code quote spoiler"></div>-->

</main>
</body>
</html>
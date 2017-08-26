<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetVisibleCount');
Model('GetVisibleTable');
Model('NoteGet');
Model('GetDiaryNews');
Model('Auth');

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

$pages = ceil(GetVisibleCount()/$GLOBALS['per_page_4main']);
if($page == $pages) {
    $lastpage = true;
}
else{
    $lastpage = false;
}

$table = GetVisibleTable(($page-1)*$GLOBALS['per_page_4main'], $GLOBALS['per_page_4main'], $lastpage, true);

$now = time();
$news = NoteGet('news', 0, 1);
$diary_news = GetDiaryNews();
$count = 0;

if(isset($_SESSION['auth']) and $_SESSION['auth'] == true) {
    $udata = Auth();
}

ViewHtmlTop("NF", 'Main.css');
ViewHeader();

?>
<div class="wrapper">
  <a class="emergency" href="<?=$script?>?c=Emergency">Угроза срыва</a>
</div>

<?php if(isset($udata)): ?>
<div class="wrapper">
  <div class="nf-timer" id="nf_timer">0 дн 00:00:00</div>
</div>
<script>
<?php
Resource('nf_timer.js');
$timer_start = $udata['time']; //+$GLOBALS['timezone_fix'];
?>
nf_timer_init(<?=$now?>);
nf_timer(<?=$timer_start?>);
setInterval('nf_timer(<?=$timer_start?>)', 500);
</script>
<?php endif; ?>

<?php if(!isset($_SESSION['auth']) or !$_SESSION['auth']): ?>
<form method="POST" action="<?=$script?>?c=Settings">
<div class="wrapper">
<?php
if(isset($_SESSION['rank_system'])) {
    $rank_system = $_SESSION['rank_system'];
}
else{
    $rank_system = $GLOBALS['rank_system'];
}
?>
  <div class="hidden_container">
    <div class="hidden-container__row">
      <div class="hidden-container__element">
        <select name="rank_system" size="1">
<?php foreach($GLOBALS['rank_systems'] as $key=>$rs): ?>
<?php if($rank_system == $key): ?>
          <option selected="selected" value="<?=$key?>"><?=$rs?></option>
<?php else: ?>
          <option value="<?=$key?>"><?=$rs?></option>
<?php endif; ?>
<?php endforeach; ?>
        </select>
      </div>
      <div class="hidden-container__element">
        <input type="submit" value="Изменить систему рангов" />
      </div>
    </div>
  </div>
</div>
</form>
<?php endif; ?>

<?php foreach($news as $key=>$value): ?>
<div class="wrapper">
  <div class="news">
    <?=nl2br($value['data'])?>
    <div class="news__date"><?=$value['at']?></div>
  </div>
</div>
<?php endforeach; ?>
<!--<div class="link"></div>-->

<div class="wrapper wrapper_text">
  <a class="link" name="top" href="#bottom">[Вниз]</a>
</div>

<div class="wrapper">

  <div class="diary-news">
    <div class="diary-news__head">
      <div class="diary-news__note"><span id="diary-news__link" class="link diary-news__ctrl-lnk" onclick="diary_news_change()">[Скрыть]</span></div>
    </div>
    <div id="diary-news__body" class="diary-news__body">
<?php foreach($diary_news as $note): ?>
<?php
$t = $note['note_time']-$note['time'];
$add = ($t > -3600 and $t < 3600) ? 'сорвался и ' : '';
?>
      <div class="diary-news__note"><a class="link" href="<?=$script?>?v=Diary&for=<?=$note['id']?>"><?=$note['nick']?></a> (<?=floor(($now-$note['time'])/(3600*24))?> дн.) <?=$add?>обновил свой дневник.</div>
<?php endforeach; ?>
    </div>
  </div>

<script>
<?php Resource('diary-news.js'); ?>
</script>

  <div class="nofap-ranks">

    <div class="nofap-ranks__row nofap-ranks__row_head">
      <div class="nofap-ranks__element">Рейтинг</div>
    </div>
<?php foreach($table as $var): ?>
<?php
if(isset($udata) and $udata['nick'] == $var[1]) {
    $add = ' nofap-ranks__row_mynick';
}
else{
    $add = '';
}
?>

    <div class="nofap-ranks__row<?=$add?>">
      <div class="nofap-ranks__element nofap-ranks__element_number">#<?=$var[0]?></div>
      <div class="nofap-ranks__element nofap-ranks__element_nick"><a class="nofap-ranks__link" href="<?=$script?>?v=Diary&for=<?=$var[4]?>"><?=$var[1]?></a></div>
      <div class="nofap-ranks__element nofap-ranks__element_period"><?=$var[2]?> дн.</div>
      <div class="nofap-ranks__element nofap-ranks__element_rank"><?=$var[3]?></div>
    </div>
<?php endforeach; ?>

  </div>
</div>

<div class="wrapper wrapper_text">
  <a class="link" name="bottom" href="#top">[Вверх]</a>
</div>

<?php
Resource("Paginator.php");
Paginator("Main", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->
</main>
</body>
</html><?php

if(isset($_SERVER['HTTP_REFERER']) and stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
    WriteLog('data/One/Referer.php', $_SERVER['HTTP_REFERER']);
}

?>
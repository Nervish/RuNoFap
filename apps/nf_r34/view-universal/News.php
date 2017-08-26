<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('NoteGet');
Model('NoteCount');

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

$pages = ceil(NoteCount('news')/$GLOBALS['per_page_4notes']);
$list = NoteGet('news', ($page-1)*$GLOBALS['per_page_4notes'], $GLOBALS['per_page_4notes']);

ViewHtmlTop("Новости", 'News.css');
ViewHeader();

?>

<?php foreach($list as $key=>$value): ?>
<div class="wrapper">
  <div class="news">
    <?=nl2br($value['data'])?>
    <div class="news__date"><?=$value['at']?></div>
  </div>
</div>
<?php endforeach; ?>
<!--<div class="link"></div>-->

<?php
Resource("Paginator.php");
Paginator("News", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->

</main>
</body>
</html>
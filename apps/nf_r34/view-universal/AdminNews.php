<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('NoteCount');
Model('NoteGet');

CheckAdminAccess();

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

$pages = ceil(NoteCount('news')/$GLOBALS['per_page_4notes']);
$list = NoteGet('news', ($page-1)*$GLOBALS['per_page_4notes'], $GLOBALS['per_page_4notes']);

ViewHtmlTop("Новости", 'AdminNews.css');
ViewHeader();

?>

<form id="a" method="POST" action="<?=$script?>?c=AdminSendNews"></form>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_theme_frosty">
      <div class="list-container__element">Добавить новость</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="a" name="news" rows="10" placeholder="Текст новости..."></textarea>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="a" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

<form id="e" method="POST" action="<?=$script?>?c=AdminEditNotes"></form>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_theme_spring">
      <div class="list-container__element">Правка новостей</div>
    </div>
<?php foreach($list as $key=>$value): ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input form="e" type="checkbox" name="d[<?=$value['id']?>]" />Удалить
      </div>
      <div class="list-container__element">
        <textarea class="list-container__input" form="e" name="note[<?=$value['id']?>]" rows="7"><?=$value['data']?></textarea>
      </div>
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="e" type="checkbox" name="e[<?=$value['id']?>]" />Обновить
      </div>
    </div>
<?php endforeach; ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="e" type="submit" value="Обновить" />
      </div>
    </div>
  </div>
</div>

<?php
Resource("Paginator.php");
Paginator("AdminNews", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->

</main>
</body>
</html>
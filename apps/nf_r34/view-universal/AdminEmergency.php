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

$pages = ceil(NoteCount('emergency_suggest')/$GLOBALS['per_page_4notes']);
$list = NoteGet('emergency_suggest', ($page-1)*$GLOBALS['per_page_4notes'], $GLOBALS['per_page_4notes']);

ViewHtmlTop("Предложения ссылок для Emergency", 'AdminEmergency.css');
ViewHeader();

?>

<form id="f" method="POST" action="<?=$script?>?c=AdminEmergency"></form>
<div class="wrapper">
  <div class="list-container size_600p">
    <div class="list-container__row list-container__row_theme_frosty">
      <div class="list-container__element">Предложения</div>
    </div>
<?php foreach($list as $key=>$value): ?>
<?php $var = json_decode($value['data'], true); ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input form="f" type="checkbox" name="d[<?=$value['id']?>]" />Удалить
      </div>
      <div class="list-container__element">
        <a class="link" href="<?=addslashes(htmlspecialchars($var['link']))?>">[o]</a>
        <input form="f" type="text" name="link[<?=$value['id']?>]" value="<?=addslashes(htmlspecialchars($var['link']))?>" />
      </div>
      <div class="list-container__element">
        <?=$var['comment']?>
      </div>
      <div class="list-container__element">
        <select form="f" name="cat[<?=$value['id']?>]" size="1">
            <option selected="selected" value="em">Угроза</option>
            <option value="rej">Отказ</option>
            <option value="dep">Депрессия</option>
            <option value="rel">Рецидив</option>
        </select>
      </div>
      <div class="list-container__element">
        <input form="f" type="checkbox" name="a[<?=$value['id']?>]" />Подтвердить
      </div>
    </div>
<?php endforeach; ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

<?php
Resource("Paginator.php");
Paginator("AdminEmergency", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->

</main>
</body>
</html>
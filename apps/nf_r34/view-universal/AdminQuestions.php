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

$pages = ceil(NoteCount('questions')/$GLOBALS['per_page_4notes']);
$list = NoteGet('questions', ($page-1)*$GLOBALS['per_page_4notes'], $GLOBALS['per_page_4notes']);

ViewHtmlTop("Просмотр вопросов", 'AdminQuestions.css');
ViewHeader();

?>

<form id="a" method="POST" action="<?=$script?>?c=AdminSendAnswer"></form>
<div class="wrapper">
  <div class="list-container size_600p">
    <div class="list-container__row list-container__row_theme_frosty">
      <div class="list-container__element">Добавить ответ</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="a" name="answer" rows="10" placeholder="Текст ответа..."></textarea>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="a" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

<form id="r" method="POST" action="<?=$script?>?c=AdminRemoveQuestion"></form>
<div class="wrapper">
  <div class="list-container size_600p">
    <div class="list-container__row list-container__row_theme_spring">
      <div class="list-container__element">Вопросы и предложения</div>
    </div>
<?php foreach($list as $key=>$value): ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input form="r" type="checkbox" name="d[<?=$value['id']?>]" />Удалить
      </div>
      <div class="list-container__element">
        <div class="answer">
          <?=nl2br($value['data'])?>
          <div class="answer__date"><?=$value['at']?></div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="r" type="submit" value="Удалить" />
      </div>
    </div>
  </div>
</div>

<?php
Resource("Paginator.php");
Paginator("AdminQuestions", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->

</main>
</body>
</html>
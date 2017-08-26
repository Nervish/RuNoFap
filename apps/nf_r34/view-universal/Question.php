<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('NoteGet');
Model('NoteCount');

if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
else
    $page = 1;

$pages = ceil(NoteCount('answers')/$GLOBALS['per_page_4notes']);
$list = NoteGet('answers', ($page-1)*$GLOBALS['per_page_4notes'], $GLOBALS['per_page_4notes']);

ViewHtmlTop("Задать вопрос", 'Question.css');
ViewHeader();

?>

<form method="POST" id="f" action="<?=$script?>?c=Question">
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Отправка сообщения</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" name="msg" form="f" rows="10" placeholder="Текст сообщения"></textarea>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>



<?php foreach($list as $key=>$value): ?>
<div class="wrapper">
  <div class="answer size_600p">
    <?=nl2br($value['data'])?>
    <div class="answer__date"><?=$value['at']?></div>
  </div>
</div>
<?php endforeach; ?>
<!--<div class="link comment"></div>-->

<?php
Resource("Paginator.php");
Paginator("Question", $page, $pages);
?>
<!--<div class="navigation navigation__paginator navigation__link navigation__hidden"></div>-->

</main>
</body>
</html>
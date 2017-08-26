<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

if(!isset($_GET['id']) or !is_numeric($_GET['id']) or $_GET['id'] <= 0) {
    ViewErrorPage("Не определен пост для комментария!");
}
$answ = $_GET['id'];

ViewHtmlTop("Написать комментарий", 'DiaryAnswer.css');
ViewHeader();

?>
<form id="f" method="POST" action="<?=$script?>?c=DiaryAnswer&id=<?=$answ?>"></form>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Ответ</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="f" name="answer" rows="12" placeholder="Текст комментария"></textarea>
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
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>
</main>
</body>
</html>
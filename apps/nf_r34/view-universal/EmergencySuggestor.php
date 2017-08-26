<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

ViewHtmlTop("Предложить", 'EmergencySuggestor.css');
ViewHeader();

?>
<form id="f" action="<?=$script?>?c=EmergencySuggestor" method="POST"></form>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Предложить ссылку</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="link" placeholder="Ссылка" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="f" name="comment" rows="7" placeholder="Комментарии, категория ссылки, email для обратной связи, пожелания."></textarea>
      </div>
    </div>
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
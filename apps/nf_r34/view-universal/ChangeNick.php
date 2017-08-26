<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');

Auth();
ViewHtmlTop("Смена ника", 'ChangeNick.css');
ViewHeader();

?>
<form method="POST" id="f" action="<?=$script?>?c=ChangeNick"></form>
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Смена ника</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="nick" placeholder="Новый ник" />
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
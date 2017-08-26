<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');

Auth();
ViewHtmlTop("Смена e-mail", 'ChangeEmail.css');
ViewHeader();

?>
<form method="POST" id="f" action="<?=$script?>?c=ChangeEmail"></form>
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Смена e-mail</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="old_email" placeholder="Старый e-mail" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="text" name="new_email" placeholder="Новый e-mail" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" type="password" name="pass" placeholder="Пароль" />
      </div>
    </div>
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
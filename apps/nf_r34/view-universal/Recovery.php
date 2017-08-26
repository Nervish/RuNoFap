<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('ReAddr');

if($_SESSION['auth']) {
    ReAddr('v=Profile');
}

ViewHtmlTop("Восстановление пароля", 'Recovery.css');
ViewHeader();

?>
<form method="POST" action="<?=$script?>?c=SendRecovery">
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Восстановление пароля</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="email" type="text" placeholder="E-mail" autofocus />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="pass" type="password" placeholder="Новый пароль" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="captcha" type="text" placeholder="Капча" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <img src="captcha.php">
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button"  type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>
</form>
</main>
</body>
</html>
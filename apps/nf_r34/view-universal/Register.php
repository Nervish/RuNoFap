<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('ReAddr');

if($_SESSION['auth']) {
    ReAddr('v=Profile');
}

ViewHtmlTop("Регистрация", 'Register.css');
ViewHeader();

?>
<form method="POST" action="<?=$script?>?c=Register">
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Регистрация</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="nick" type="text" placeholder="Ник" autofocus />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="email" type="text" placeholder="E-mail" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="pass" type="password" placeholder="Пароль" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="date" type="text" placeholder="Время начала" value="<?=date("d.m.Y H:i:s")?>" />
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
        <input class="list-container__input list-container__input_button"  type="submit" value="Поехали!" />
      </div>
    </div>
  </div>
</div>
</form>
</main>
</body>
</html>
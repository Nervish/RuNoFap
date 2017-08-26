<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('ReAddr');

if($_SESSION['auth']) {
    ReAddr('v=Profile');
}

ViewHtmlTop("Вход", 'Login.css');
ViewHeader();

?>
<form method="POST" action="<?=$script?>?c=Login">
<div class="wrapper">
  <div class="list-container size_240p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Вход</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="login" type="text" placeholder="Логин" autofocus />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" name="pass" type="password" placeholder="Пароль" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=Recovery">Восстановить пароль</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input list-container__input_button" type="submit" value="Войти" />
      </div>
    </div>
  </div>
</div>
</form>
</main>
</body>
</html>
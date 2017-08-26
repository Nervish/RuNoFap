<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');

CheckAdminAccess();

ViewHtmlTop("Написать письмо", 'AdminEmail.css');
ViewHeader();

?>

<form id="f" method="POST" action="<?=$script?>?c=AdminEmail"></form>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Отправка сообщения</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" name="from" placeholder="Ящик админа" value="<?=$GLOBALS['admin_email']?>" type="text" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" name="to" placeholder="Имя адресата <email@mail.ru>" type="text" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <input class="list-container__input" form="f" name="subject" placeholder="Тема" type="text" />
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <textarea class="list-container__input" form="f" name="msg" rows="10" placeholder="Текст сообщения..."></textarea>
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
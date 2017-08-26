<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');

CheckAdminAccess();

ViewHtmlTop("Админка", 'Admin.css');
ViewHeader();

?>
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_theme_spring">
      <div class="list-container__element">Панель управления</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminNews">Новости</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminVotings">Голосования</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminAccountList">Список аккаунтов</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminQuestions">Просмотр вопросов</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminAnswers">Ответы на вопросы</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminNoFapWar">Управление NoFap-войной</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminEmergency">Предложения ссылок Emergency</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminEmail">Написать письмо</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminEditLinks">Изменить ссылки</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminEditFiles">Изменить файлы</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminClean">Очистка</a></div>
    </div>
  </div>
</div>
</main>
</body>
</html>
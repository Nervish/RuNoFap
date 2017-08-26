<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');

CheckAdminAccess();

ViewHtmlTop("Управление NoFap-войной", 'AdminNoFapWar.css');
ViewHeader();

?>
<div class="wrapper">
  <div class="list-container size_300p">
    <div class="list-container__row list-container__row_theme_spring">
      <div class="list-container__element">Управление войной</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminNoFapWarArmies">Армии</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminNoFapWars">Войны</a></div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element"><a class="link" href="<?=$script?>?v=AdminNoFapWarMembers">Статистика участников</a></div>
    </div>
  </div>
</div>
</main>
</body>
</html>
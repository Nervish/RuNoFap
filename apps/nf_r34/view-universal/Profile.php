<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('SetIP');
Model('GetField');
Model('GetPosition');
Model('GetWar');
Model('GetFails');

$udata = Auth();
SetIP($_SESSION['email']);
$war = GetWar();
$now = time();
$time = date("d.m.Y H:i:s", $udata['time']);
$position = GetPosition($udata['id']);

ViewHtmlTop("Профиль", 'Profile.css');
ViewHeader();

?>

<?php if(isset($udata)): ?>
<div class="wrapper">
  <div class="nf-timer" id="nf_timer">0 дн 00:00:00</div>
</div>
<script>
<?php
Resource('nf_timer.js');
$timer_start = $udata['time']; //+$GLOBALS['timezone_fix'];
?>
nf_timer_init(<?=$now?>);
nf_timer(<?=$timer_start?>);
setInterval('nf_timer(<?=$timer_start?>)', 500);
</script>
<?php endif; ?>

<form method="POST" id="f" action="<?=$script?>?c=UpdateStatus&s=failtime"></form>
<div class="wrapper">
  <div class="hidden-container">
    <div class="hidden-container__row">
      <div class="hidden-container__element">Ты</div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element"></div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element">
        <a class="status-button status-button_nice status-button_link" href="<?=$script?>?c=UpdateStatus&s=ok"> на коне</a>
      </div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element"></div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element">или</div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element">
        <input class="status-button status-button_fail" type="submit" form="f" onclick="return confirm('Подтверждение срыва. Ты точно сорвался?')" value="сорвался" />
      </div>
      <div class="hidden-container__element">
        <input name="faildate" form="f" type="text" value="<?=date("d.m.Y H:i:s", time())?>" />
      </div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element"></div>
    </div>
  </div>
</div>

<form method="POST" id="update" action="<?=$script?>?c=UpdateStatus&s=update"></form>
<div class="wrapper">
  <div class="hidden-container">
    <div class="hidden-container__row">
      <div class="hidden-container__element">Также можно вручную</div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element"></div>
    </div>
    <div class="hidden-container__row">
      <div class="hidden-container__element">
        <input name="date" form="update" type="text" value="<?=$time?>" />
      </div>
      <div class="hidden-container__element">
        <input class="status-button status-button_update" form="update" type="submit" value="Обновить время начала" />
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  <div class="list-container size_360p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Разное</div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=Diary&for=<?=$udata['id']?>">Дневник</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=FailStat">Личная статистика</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=Settings">Настройки</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=ChangeNick">Смена ника</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=ChangePassword">Смена пароля</a>
      </div>
    </div>
    <div class="list-container__row">
      <div class="list-container__element">
        <a class="link" href="<?=$script?>?v=ChangeEmail">Смена e-mail</a>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  <div class="list-container size_360p">
    <div class="list-container__row list-container__row_theme_frosty">
      <div class="list-container__element">Информация</div>
    </div>
<?php if($war and $udata['army'] != 'empty' and $udata['army'] != 'enter'): ?>
    <div class="list-container__row list-container__text">
      <div class="list-container__element">Армия: <?=$udata['army']?></div>
    </div>
<?php endif; ?>
    <div class="list-container__row list-container__text">
      <div class="list-container__element">Дней: <?=floor((time()-$udata['time'])/(3600*24))?></div>
    </div>
    <div class="list-container__row list-container__text">
      <div class="list-container__element">Срывов: <?=GetFails($udata['email'])['all']?></div>
    </div>
    <div class="list-container__row list-container__text">
      <div class="list-container__element">Позиция в рейтинге: <?=$position?></div>
    </div>
    <div class="list-container__row list-container__text">
      <div class="list-container__element">Аккаунт создан: <?=date('d.m.Y H:i', $udata['c_time'])?></div>
    </div>
  </div>
</div>

</main>
</body>
</html>
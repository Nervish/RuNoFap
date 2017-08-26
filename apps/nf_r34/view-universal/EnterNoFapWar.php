<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetWar');
Model('GetNoFapArmies');
//Model('GetNoFapWarTable');

$war = GetWar();
$armies = GetNoFapArmies();
$army_stat = GetNoFapArmies(false);

//var_dump($army_stat);die;

$arm = array();
foreach($armies as $army) {
    $arm[$army['id']] = $army;
    if(isset($_SESSION['auth']) and $_SESSION['auth']) {
        $udata = Auth();
        if($army['name'] == $udata['army']) {
            $myarmyid = $army['id'];
        }
    }
}

$time = time();
if($war['start'] <= $time and $war['finish'] >= $time) {
    $iswar = true;
    /*$table = GetNoFapWarTable();
    $max = count($table['side_a']['members']);
    $tmp = count($table['side_b']['members']);
    if($tmp > $max) {
        $max = $tmp;
    }*/
}
else{
    $iswar = false;
}

ViewHtmlTop("NoFapWar", 'EnterNoFapWar.css');
ViewHeader();

?>

<div class="wrapper">
  <div class="news">
Нофап-война проводится в несколько этапов.<br />
Вначале пользователи определяют, будут ли они участвовать.<br />
Далее предлагают в треде нофап-войны названия армий.<br />
Затем идет голосование - какие названия армий будут выбраны. Армий две, названия могут быть связанными (СССР/Рейх, Красные/Белые), либо же произвольными.<br />
После этого пользователи выбирают сторону, и начинается война.<br />
Каждую неделю нужно отмечаться, не отметился - выбыл.<br />
Сорвался - погиб на войне.<br />
Война длится 28 дней.<br />
Координация действий проводится в <a class="link" href="https://nofap.ru/index.php?v=ShowThread&thread=71">в этом треде</a>, если участвуете - периодически проверяйте тред на наличие новостей.
    <div class="news__date">28.01.2017 18:00</div>
  </div>
</div>

<div class="hidden-container">
<?php if(isset($udata)): ?>
<?php if($udata['army'] == 'empty'): ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Вы не выражали желание участвовать в войне.</div>
  </div>
<?php if(!$iswar): ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Если желаете принять участие в нофап-войне, жмите <a class="link" href="<?=$script?>?c=EnterNoFapWar&d=enter">сюда</a>.</div>
  </div>
<?php endif; ?>
<?php elseif($udata['army'] == 'enter'): ?>
<?php if($war['recruting']): ?>
<form id="f" method="POST" action="<?=$script?>?c=NoFapWarChoose">
  <div class="hidden-container__row">
    <div class="hidden-container__element">Армия, которая вам больше по душе: </div>
  </div>
  <div class="hidden-container__row">
    <div class="hidden-container__element">
      <input form="f" type="radio" name="army" value="<?=$arm[$war['side_a']]['id']?>"><?=$arm[$war['side_a']]['name']?>
    </div>
  </div>
  <div class="hidden-container__row">
    <div class="hidden-container__element">
      <input form="f" type="radio" name="army" value="<?=$arm[$war['side_b']]['id']?>"><?=$arm[$war['side_b']]['name']?>
    </div>
  </div>
  <div class="hidden-container__row">
    <div class="hidden-container__element">
      <input form="f" type="submit" value="Выбрать" />
    </div>
  </div>
<?php else: ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">В данный момент набор в армии не ведется.</div>
  </div>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Если вы передумали участвовать, вы еще можете <a class="link" href="<?=$script?>?c=EnterNoFapWar&d=exit">покинуть отряд рекрутов</a>.</div>
  </div>
<?php endif; ?>
<?php else: ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Вы приняли сторону армии "<?=$arm[$myarmyid]['name']?>".</div>
  </div>
<?php if(!$iswar): ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Если вы передумали участвовать или решили сменить сторону, вы еще можете <a class="link" href="<?=$script?>?c=EnterNoFapWar&d=exit">покинуть армию</a>.</div>
  </div>
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
  <div class="hidden-container__row">
    <div class="hidden-container__element">Если желаете принять участие в нофап-войне, то войдите в аккаунт или зарегистрируйтесь.</div>
  </div>
<?php endif; ?>
</div>

<div class="wrapper">
  <div class="list-container">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Армии</div>
    </div>
<?php foreach($army_stat as $var): ?>
<?php if($var['army'] == 'empty' or $var['army'] == 'enter') {
    continue;
}
?>
    <div class="list-container__row">
      <div class="list-container__element"><?=$var['army']?>/<?=$var['count(*)']?></div>
    </div>
<?php endforeach; ?>
  </div>
</div>

</main>
</body>
</html>
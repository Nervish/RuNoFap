<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetWarChronicle');
Model('GetNoFapArmies');

$chronicle = GetWarChronicle();
$war = GetWar();
$armies = GetNoFapArmies();
$now = time();

$arms = array();
foreach($armies as $army) {
    $arms[$army['name']] = $army;
}

if($war and $war['start'] < $now and $war['finish'] > $now) {
    $iswar = true;
}
else{
    $iswar = false;
}

ViewHtmlTop('Военная хроника', 'WarChronicle.css');
ViewHeader();

?>

<?php Resource('ArmyStyles.php'); ?>

<div class="wrapper">
<?php if($iswar and $war and is_array($war)): ?>
<?php if(empty($chronicle)): ?>
В данный момент потерь нет.
<?php else: ?>
  <div class="list-container size_720p">
    <div class="list-container__row list-container__row_theme_frosty">
      <div class="list-container__element">Военная хроника</div>
    </div>
<?php foreach($chronicle as $var): ?>
    <div class="list-container__row list-container__text">
      <div class="list-container__element"><?=date('d.m.Y H:i', $var['time'])?> 
<span class="post__flair post__flair--army<?=$arms[$var['army']]['id']?>"><?=$var['army']?></span>
 <?=$var['nick']?> погиб на <?=$var['at_day']?>-м дне своего нофапа.</div>
    </div>
<?php endforeach; ?>
  </div>
<?php endif; ?>
<?php else: ?>
В данный момент война не ведется, хроника не доступна.
<?php endif; ?>
</div>
<!--<div class="post">-->
</main>
</body>
</html>
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetWar');
Model('GetNoFapArmies');

$war = GetWar();
$armies = GetNoFapArmies();

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
}
else{
    $iswar = false;
}

ViewHtmlTop("Партизанская война", 'RebellArmy.css');
ViewHeader();

?>

<div class="wrapper">
  <div class="news">
Многие наши граждане ушли на войну и сражаются на передовой.<br />
Кто-то струсил и не пошел добровольцем, но некоторые не успели вовремя прийти на сборы и теперь жалеют.<br />
Однако, выход есть! Присоединяйтесь к партизанскому движению, помогайте своей армии, совершайте диверсии в ряду врага!<br />
Соберитесь ради победы и медленно, но верно сломите дух врага!<br />
<br />
Сбор на партизанскую войну действует от начала войны и до ее середины.<br />
    <div class="news__date">17.03.2017</div>
  </div>
</div>

<div class="wrapper">
<?php if($iswar): ?>
<?php if(time() <= (($war['finish']-$war['start'])/2+$war['start'])): ?>
<?php if(isset($udata)): ?>
<?php if($udata['army'] == 'empty' or $udata['army'] == 'enter'): ?>
Вы желаете записаться в армию "<?=$GLOBALS['rebell_army']?>"? <br />
<a class="link" href="<?=$script?>?c=RebellArmy">Да, я согласен.</a>
<?php else: ?>
<?php if($udata['army'] == $GLOBALS['rebell_army']): ?>
Вы уже находитесь в армии "<?=$GLOBALS['rebell_army']?>".
<?php else: ?>
Кажется, вы уже приняли сторону некой армии.
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
Для вступления в армию "<?=$GLOBALS['rebell_army']?>" следует войти в аккаунт.
<?php endif; ?>
<?php else: ?>
Кажется, прошло уже много времени с начала  войны. Записаться в армию "<?=$GLOBALS['rebell_army']?>" невозможно.
<?php endif; ?>
<?php else: ?>
В данный момент война не ведется.
<?php endif; ?>
</div>

</main>
</body>
</html>
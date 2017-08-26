<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetWar');
Model('GetNoFapArmies');
//Model('GetNoFapWarTable');

$udata = Auth();
$war = GetWar();
$armies = GetNoFapArmies();

$arm = array();
foreach($armies as $army) {
    $arm[$army['id']] = $army;
    if($army['name'] == $udata['army']) {
        $myarmyid = $army['id'];
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

ViewHtmlTop("NoFapWar");
ViewHeader();

?>
<div class="news">
<div class="left">
Нофап-война проводится в несколько этапов.<br />
Вначале пользователи определяют, будут ли они участвовать.<br />
Далее предлагают в треде нофап-войны названия армий.<br />
Затем идет голосование - какие названия армий будут выбраны. Армий две, названия могут быть связанными (СССР/Рейх, Красные/Белые), либо же произвольными.<br />
После этого пользователи выбирают сторону (тут еще могут быть изменения, чтобы не было дисбаланса в армиях), и начинается война.<br />
Каждую неделю нужно отмечаться, не отметился - выбыл.<br />
Сорвался - погиб на войне.<br />
Война длится 28 дней.<br />
Координация действий проводится в <a href="https://nofap.ru/index.php?v=ShowThread&thread=71">в этом треде</a>, если участвуете - периодически проверяйте тред на наличие новостей.
</div>
</div>
<div>
<?php if(isset($_SESSION['auth']) and $_SESSION['auth']): ?>
<?php $udata = Auth(); ?>
<?php if($udata['army'] == 'empty'): ?>
Вы не выражали желание участвовать в войне. <br />
<?php if(!$iswar): ?>
Если желаете принять участие в нофап-войне, жмите <a href="<?=$script?>?c=EnterNoFapWar&d=enter">сюда</a>.
<?php endif; ?>
<?php elseif($udata['army'] == 'enter'): ?>
<?php if($war['recruting']): ?>
<form method="POST" action="<?=$script?>?c=NoFapWarChoose">
Армия, которая вам больше по душе: <br />
<input type="radio" name="army" value="<?=$arm[$war['side_a']]['id']?>"><?=$arm[$war['side_a']]['name']?><br />
<input type="radio" name="army" value="<?=$arm[$war['side_b']]['id']?>"><?=$arm[$war['side_b']]['name']?><br />
<input type="submit" value="Выбрать" />
</form>
<?php else: ?>
В данный момент набор в армии не ведется.
Если вы передумали участвовать, вы можете <a href="<?=$script?>?c=EnterNoFapWar&d=exit">покинуть отряд рекрутов</a>.
<?php endif; ?>
<?php else: ?>
Вы приняли сторону армии "<?=$arm[$myarmyid]['name']?>".<br />
<?php if(!$iswar): ?>
Если вы передумали участвовать, вы можете <a href="<?=$script?>?c=EnterNoFapWar&d=exit">покинуть армию</a>.
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
Если желаете принять участие в нофап-войне, то войдите в аккаунт или зарегистрируйтесь.
<?php endif; ?>
</div>
<?php if(false and $iswar): ?>
<div>
<table>
<thead>
<tr><td><?=$table['side_a']['name']?></td><td><?=$table['side_b']['name']?></td></tr>
</thead>
<tbody>
<?php for($i = 0; $i < $max; $i++): ?>
<tr><td><?php if(isset($table['side_a']['members'][$i])): ?><?=$table['side_a']['members'][$i]?><?php endif; ?></td><td><?php if(isset($table['side_b']['members'][$i])): ?><?=$table['side_b']['members'][$i]?><?php endif; ?></td></tr>
<?php endfor; ?>
</tbody>
</table>
</div>
<?php endif; ?>
</div>
</body>
</html>
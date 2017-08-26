<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetWar');
Model('GetNoFapArmies');
Model('GetNoFapWarTable');
//Model('GetNoFapWarDays');

$war = GetWar();
$armies = GetNoFapArmies();
$now = time();
//$days = GetNoFapWarDays();

$arm = array();
foreach($armies as $army) {
    $arm[$army['id']] = $army;
    /*if($army['name'] == $udata['army']) {
        $myarmyid = $army['id'];
    }*/
}

$time = time();
if($war['start'] <= $time and $war['finish'] >= $time) {
    $iswar = true;
    $table = GetNoFapWarTable();
}
else{
    $iswar = false;
}

ViewHtmlTop("Армии", 'NoFapWarArmies.css');
ViewHeader();

?>

<?php Resource('WarStatStyle.php'); ?>

<?php if(isset($table) and is_array($table) and !empty($table)): ?>
<div class="wrapper">

  <div class="wrapper">
    <div class="list-container size_300p">
      <div class="list-container__row_nohower war-stat-table__item--army<?=$table['side_a']['id']?>">
        <div class="list-container__element"><?=$table['side_a']['name']?></div>
      </div>
<?php foreach($table['side_a']['members'] as $member): ?>
      <div class="list-container__row"<?=($member['status'] != 'fighting')?' style="background-color: #cccccc"':''?>>
        <div class="list-container__element"><a class="link" href="<?=$script?>?v=Diary&for=<?=$member['id']?>"><?=$member['nick']?></a><?php
if($member['status'] == 'lose') echo ' (погиб)';
elseif($member['status'] == 'lost') echo ' (пропал)';
?> <?=floor(($now-$member['time'])/(3600*24))?> дн.</div>
      </div>
<?php endforeach; ?>
    </div>
  </div>
  <div class="wrapper">
    <div class="list-container size_300p">
      <div class="list-container__row_nohower war-stat-table__item--army<?=$table['side_b']['id']?>">
        <div class="list-container__element"><?=$table['side_b']['name']?></div>
      </div>
<?php foreach($table['side_b']['members'] as $member): ?>
      <div class="list-container__row"<?=($member['status'] != 'fighting')?' style="background-color: #cccccc"':''?>>
        <div class="list-container__element"><a class="link" href="<?=$script?>?v=Diary&for=<?=$member['id']?>"><?=$member['nick']?></a><?php
if($member['status'] == 'lose') echo ' (погиб)';
elseif($member['status'] == 'lost') echo ' (пропал)';
?> <?=floor(($now-$member['time'])/(3600*24))?> дн.</div>
      </div>
<?php endforeach; ?>
    </div>
  </div>

</div>

<!--<div class="war-stat"></div>-->

<?php else: ?>
<div class="wrapper">
В данный момент война не проводится, поэтому список армий не доступен.
</div>
<?php endif; ?>

</main>
</body>
</html>
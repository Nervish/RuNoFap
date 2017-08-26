<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('WarMemorial');

$data = WarMemorial();

ViewHtmlTop("Летопись", 'WarMemorial.css');
ViewHeader();
#       <div class="war-memorial__element war-memorial__time"><?=date('d.m.Y H:i:s', $data['wars'][$c]['finish'])</div>
?>

<?php Resource('WarStatStyle.php'); ?>

<div class="wrapper">
  <div class="war-memorial">
    <div class="war-memorial__row">
      <div class="war-memorial__element war-memorial__head">Военная летопись</div>
    </div>
    <div class="war-memorial__row">
      <div class="war-memorial__element war-memorial__war war-memorial__war_head">Война</div>
      <div class="war-memorial__element war-memorial__army war-memorial__army_head">Победители</div>
      <div class="war-memorial__element war-memorial__time war-memorial__time_head">Время проведения</div>
      <div class="war-memorial__element war-memorial__number war-memorial__number_head">Участников</div>
      <div class="war-memorial__element war-memorial__number war-memorial__number_head">Выживших</div>
    </div>
<?php $c = 1; ?>
<?php foreach($data['list'] as $key=>$var): ?>
    <div class="war-memorial__row">
      <div class="war-memorial__element war-memorial__war"><?=$c?></div>
      <div class="war-memorial__element war-memorial__army war-stat__remain--army<?=$key?>"><?=$var['name']?></div>
      <div class="war-memorial__element war-memorial__time">
        <div class="war-memorial__time_start"><?=date('d.m.Y H:i:s', $data['wars'][$c]['start'])?></div>
        <div class="war-memorial__time_finish"><?=date('d.m.Y H:i:s', $data['wars'][$c]['finish'])?></div>
      </div>

      <div class="war-memorial__element war-memorial__number"><?=$var['play']?></div>
      <div class="war-memorial__element war-memorial__number"><?=$var['alive']?></div>
    </div>
<?php $c++; ?>
<?php endforeach; ?>
  </div>
</div>

</main>
</body>
</html>
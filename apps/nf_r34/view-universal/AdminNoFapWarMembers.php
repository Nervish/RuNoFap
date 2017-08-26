<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetNoFapArmies');

CheckAdminAccess();
$data = GetNoFapArmies(false);

ViewHtmlTop("Распределение участников", 'AdminNoFapWarMembers.css');
ViewHeader();

?>

<?php Resource('WarStatStyle.php'); ?>

<div class="wrapper">
  <div class="war-members">
    <div class="war-members__row">
      <div class="war-members__element war-members__head">Активные участники</div>
    </div>
<?php foreach($data as $var): ?>
    <div class="war-members__row">
      <div class="war-members__element war-members__army war-stat__remain--army<?=$var['id']?>"><?=$var['army']?></div>
      <div class="war-members__element war-members__members"><?=$var['count(*)']?></div>
    </div>
<?php endforeach; ?>
  </div>
</div>

</main>
</body>
</html>
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('FailsStat');

$global_stat = FailsStat();

ViewHtmlTop("Общая статистика срывов по дням", 'FailsInfo.css');
ViewHeader();

?>

<div class="wrapper">
  <div class="fail-stat">
    <div class="fail-stat__head">Статистика сервера</div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">День</div>
      <div class="fail-stat__column fail-stat__column_b">Срывов</div>
    </div>
<?php foreach($global_stat as $var): ?>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a"><?=$var['at_day']?></div>
      <div class="fail-stat__column fail-stat__column_b"><?=$var['count(*)']?></div>
    </div>
<?php endforeach; ?>
  </div>
</div>

</main>
</body>
</html>
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('GetFails');
Model('FailsStat');

$udata = Auth();

$fails = GetFails($_SESSION['email']);
$personal_stat = FailsStat($_SESSION['email']);

ViewHtmlTop("Статистика срывов", 'FailStat.css');
ViewHeader();

?>

<div class="wrapper">
  <div class="fail-stat">
    <div class="fail-stat__head">Статистика срывов</div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">За сутки</div>
      <div class="fail-stat__column fail-stat__column_b"><?=$fails['day']?></div>
    </div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">За неделю</div>
      <div class="fail-stat__column fail-stat__column_b"><?=$fails['week']?></div>
    </div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">За месяц</div>
      <div class="fail-stat__column fail-stat__column_b"><?=$fails['month']?></div>
    </div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">За все время</div>
      <div class="fail-stat__column fail-stat__column_b"><?=$fails['all']?></div>
    </div>
  </div>
</div>

<div class="wrapper">
  <div class="fail-stat">
    <div class="fail-stat__head">Подробная статистика</div>
    <div class="fail-stat__columns">
      <div class="fail-stat__column fail-stat__column_a">День</div>
      <div class="fail-stat__column fail-stat__column_b">Срывов</div>
    </div>
<?php foreach($personal_stat as $var): ?>
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
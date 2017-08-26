<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('GetNoFapArmies');
Model('AdminNoFapWars');

CheckAdminAccess();

$data = GetNoFapArmies();
$armies = array();
foreach($data as $var) {
    $armies[$var['id']] = $var['name'];
}

$data = AdminNoFapWars();
//var_dump($data);die;
ViewHtmlTop("Войны", 'AdminNoFapWars.css');
ViewHeader();

?>

<form id="f" method="POST" action="<?=$script?>?c=AdminEditWars"></form>
<div class="wrapper">
  <div class="nf-wars">
    <div class="nf-wars__row">
      <div class="nf-wars__element nf-wars__element_del nf-wars__element_del_head">x</div>
      <div class="nf-wars__element nf-wars__element_times nf-wars__element_times_head">Сроки</div>
      <div class="nf-wars__element nf-wars__element_sides nf-wars__element_sides_head">Стороны</div>
      <div class="nf-wars__element nf-wars__element_recruting nf-wars__element_recruting_head">Рекрутинг</div>
      <div class="nf-wars__element nf-wars__element_update nf-wars__element_update_head">Обновить</div>
    </div>
<?php if($data): ?>
<?php foreach($data as $war): ?>
    <div class="nf-wars__row">
      <div class="nf-wars__element nf-wars__element_del">
        <input form="f" type="checkbox" name="d[<?=$war['id']?>]" />
      </div>
      <div class="nf-wars__element nf-wars__element_times">
        <div class="nf-wars__part_top">
          <input form="f" class="nf-wars__input" type="text" name="start[<?=$war['id']?>]" value="<?=date('d.m.Y H:i:s', $war['start'])?>" />
        </div>
        <div class="nf-wars__part_bottom">
          <input form="f" class="nf-wars__input" type="text" name="finish[<?=$war['id']?>]" value="<?=date('d.m.Y H:i:s', $war['finish'])?>" />
        </div>
      </div>
      <div class="nf-wars__element nf-wars__element_sides">
        <div class="nf-wars__part_top">
          <select form="f" class="nf-wars__input" name="side_a[<?=$war['id']?>]" size="1">
<?php foreach($armies as $key=>$value): ?>
<?php if($war['side_a'] == $key): ?>
            <option selected="selected" value="<?=$key?>"><?=$value?></option>
<?php else: ?>
            <option value="<?=$key?>"><?=$value?></option>
<?php endif; ?>
<?php endforeach; ?>
          </select>
        </div>
        <div class="nf-wars__part_bottom">
          <select form="f" class="nf-wars__input" name="side_b[<?=$war['id']?>]" size="1">
<?php foreach($armies as $key=>$value): ?>
<?php if($war['side_b'] == $key): ?>
            <option selected="selected" value="<?=$key?>"><?=$value?></option>
<?php else: ?>
            <option value="<?=$key?>"><?=$value?></option>
<?php endif; ?>
<?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="nf-wars__element nf-wars__element_recruting">
        <input form="f" type="checkbox" name="recruting[<?=$war['id']?>]" <?= ($war['recruting']) ? 'checked ' : ''?>/>
      </div>
      <div class="nf-wars__element nf-wars__element_update">
        <input form="f" type="checkbox" name="e[<?=$war['id']?>]" />
      </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
    <div class="nf-wars__row">
      <div class="nf-wars__element nf-wars__element_full">
        <input form="f" class="nf-wars__input" type="text" name="add" placeholder="Добавить записей:" />
      </div>
    </div>
    <div class="nf-wars__row">
      <div class="nf-wars__element nf-wars__element_full">
        <input form="f" type="submit" value="Отправить" />
      </div>
    </div>
  </div>
</div>

</main>
</body>
</html>
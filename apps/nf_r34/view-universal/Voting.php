<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetVoting');
Model('GetEmail');

if(isset($_SESSION['auth']) and $_SESSION['auth']) {
    $udata = GetEmail($_SESSION['email']);
    $user_id = $udata['id'];
}
else{
    $user_id = "";
}

ViewHtmlTop("Голосование", 'Voting.css');
ViewHeader();

?>
<?php if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0): ?>
<?php $voting = GetVoting($_GET['id'], $user_id); ?>
<?php if(!$voting): ?>
<div class="wrapper">Выбранного голосования не существует.</div>
<?php else: ?>

<?php $vote_id = $voting['id']; ?>
<div class="wrapper wrapper_column">
<b><?=nl2br($voting['name'])?></b><br />
<?=nl2br($voting['descript'])?>
</div>

<?php if($user_id): ?>
<form id="f" method="POST" action="<?=$script?>?c=Voting&vs=<?=$vote_id?>"></form>
<?php endif; ?>
<div class="wrapper">
  <div class="list-container size_480p">
    <div class="list-container__row list-container__row_head">
      <div class="list-container__element">Голосование</div>
    </div>
<?php
$order = array();
$keys = array();
/*foreach($voting['votes'] as $key=>$value) {
    array_push($order, $key);
    $keys[$key] = true;
}*/
foreach($voting['chooses'] as $key=>$value) {
    if(!isset($result['votes'][$key])) {
        array_push($order, $key);
        //$keys[$key] = true;
    }
}
//var_dump($order);die;
?>
<?php if($voting['mult']): ?>
<?php $cc = count($order); ?>
<?php for($i = 0; $i < $cc; $i++): ?>
<?php
$k = $order[$i];
$value = $voting['chooses'][$k];
$v = (isset($voting['votes'][$k])) ? $voting['votes'][$k] : 0;
?>    <div class="list-container__row">
      <div class="list-container__element list-container__text">
<?php if($voting['active'] and $user_id): ?>
<?php
$c = (isset($voting['user_chooses'][$k])) ? 'checked ' : '';
$name = $k;
?>        <input form="f" type="checkbox" name="v[<?=$vote_id?>][<?=$name?>]" <?=$c?>/>
<?php endif; ?>        <?=$value['choose']?>   <span>[голосов:  <?=$v?>]</span>
      </div>
    </div>
<?php endfor; ?>
<?php else: ?>
<?php $cc = count($order); ?>
<?php for($i = 0; $i < $cc; $i++): ?>
<?php
$k = $order[$i];
$value = $voting['chooses'][$k];
$v = (isset($voting['votes'][$k])) ? $voting['votes'][$k] : 0;
?>    <div class="list-container__row">
      <div class="list-container__element list-container__text">
<?php if($voting['active'] and $user_id): ?>
<?php
$c = (isset($voting['user_chooses'][$k])) ? 'checked ' : '';
$name = $k;
?>        <input form="f" type="radio" name="v[<?=$vote_id?>]" value="<?=$name?>" <?=$c?>/>
<?php endif; ?>      <?=$value['choose']?>   <span>[голосов:  <?=$v?>]</span>
      </div>
    </div>
<?php endfor; ?>
<?php endif; ?>
    <div class="list-container__row">
      <div class="list-container__element">
<?php if($voting['active']): ?>
<?php if($user_id): ?>
        <input class="list-container__input list-container__input_button" form="f" type="submit" value="Голосовать" />
<?php else: ?>
        <p>Для голосования необходимо войти.</p>
<?php endif; ?>
<?php else: ?>
        <p>Голосование закрыто.</p>
<?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
<?php else: ?>
<div class="wrapper">
Неправильно указан идентификатор голосования!
</div>
<?php endif; ?>
</main>
</body>
</html>
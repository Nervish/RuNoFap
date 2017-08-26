<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('SetField');
Model('GetWar');
Model('ReAddr');

$udata = Auth();
$war = GetWar();

$time = time();
if($war and $war['start'] <= $time and $war['finish'] >= $time) {
    ViewErrorPage("Началась война, вы больше не можете изменить армию, вступить в армию или покинуть ее.");
}

if(isset($_GET['d']) and !empty($_GET['d'])) {
    if($_GET['d'] == 'enter') {
        SetField('nofap', 'army', 'enter', $udata['email']);
    }
    elseif($_GET['d'] == 'exit') {
        SetField('nofap', 'army', 'empty', $udata['email']);
    }
    else{
        ViewErrorPage("Некорректная ссылка!");
    }
}

ReAddr('v=EnterNoFapWar', true);

<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('SetField');
Model('GetNoFapArmies');
Model('ReAddr');

$udata = Auth();
$armies = GetNoFapArmies();
$arm = array();
foreach($armies as $army) {
    $arm[$army['id']] = $army;
}

if(isset($_POST['army']) and !empty($_POST['army'])) {
    $army = $_POST['army'];
    if(isset($arm[$army])) {
        SetField('nofap', 'army', $arm[$army]['name'], $udata['email']);
    }
    else{
        ViewErrorPage("Некорректный идентификатор армии!");
    }
}
ReAddr('v=EnterNoFapWar');
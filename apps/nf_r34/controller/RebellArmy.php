<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('SetField');
Model('ReAddr');

$udata = Auth();

if($udata['army'] == 'empty' or $udata['army'] == 'enter') {
    SetField($GLOBALS['db_table'], 'army', $GLOBALS['rebell_army'], $_SESSION['email']);
}
else{
    ViewErrorPage("Кажется, вы уже приняли сторону некой армии.");
}

ReAddr('', true);
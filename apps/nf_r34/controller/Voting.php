<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('Vote');
Model('ReAddr');

$udata = Auth();

if(isset($_GET['vs']) and !empty($_GET['vs']) and is_numeric($_GET['vs']) and $_GET['vs'] > 0) {
    if(isset($_POST['v']) and is_array($_POST['v'])) {
        Vote($udata['id'], $_GET['vs'], $_POST['v']);
    }
    else{
        Vote($udata['id'], $_GET['vs']);
    }
}
ReAddr('', true);
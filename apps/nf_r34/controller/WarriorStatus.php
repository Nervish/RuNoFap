<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('Update');
Model('ReAddr');

Auth();

if(isset($_GET['s']) and !empty($_GET['s'])) {
    $status = $_GET['s'];
    if($status == 'fighting') {
        Update($_SESSION['email'], 'ok');
    }
    elseif($status == 'lose') {
        Update($_SESSION['email'], 'failtime', date('d.m.Y H:i:s'));
    }
    else{
        ViewErrorPage("Некорректная ссылка!");
    }
}

ReAddr('v=NoFapWar', true);

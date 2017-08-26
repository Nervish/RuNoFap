<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');

function Auth() {
    if(!isset($_SESSION['auth']) or !$_SESSION['auth']) {
        ViewErrorPage("Для просмотра необходимо войти в аккаунт.");
    }
    $udata = GetEmail($_SESSION['email']);
    if($udata['ulock']) {
        $_SESSION = array();
        session_destroy();
        ViewErrorPage("Учетная запись заблокирована!");
    }
    return $udata;
}
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');
Model('EditDiary');
Model('ReAddr');

if( ! (isset($_SESSION['auth']) and $_SESSION['auth']) ) {
    ViewErrorPage("Необходимо войти для изменения свойств записей в дневнике.");
}

$udata = GetEmail($_SESSION['email']);

if(isset($_GET['id']) and !empty($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0 and isset($_GET['d']) and !empty($_GET['d'])) {
    if($_GET['d'] == 'show') {
        $d = true;
    }
    else{
        $d = false;
    }
    $id = EditDiary($udata['id'], $_GET['id'], $d);
    ReAddr('v=Diary&for='.$udata['id']);
}
else{
    ViewErrorPage("Некорректная ссылка для изменения свойства записи в дневнике.");
}

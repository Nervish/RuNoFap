<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('DiaryDeleteNote');
Model('ReAddr');

$udata = Auth();

if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0) {
    DiaryDeleteNote($_SESSION['email'], $_GET['id']);
    ReAddr("v=Diary&for=".$udata['id']);
}
else{
    ViewErrorPage("Ошибка удаления: некорректные данные.");
}
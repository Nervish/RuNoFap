<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');
Model('NoteAdd');

CheckAdminAccess();

if(isset($_POST['news']) and strlen($_POST['news']) > 0) {
    if(strlen($_POST['news']) > 60000) {
        ViewErrorPage("Новость слишком длинная!");
    }
    
    NoteAdd('news', $_POST['news'], time());
    
    ReAddr('v=AdminNews');
}
else{
    ViewErrorPage("Произошла ошибка при отправке новости.");
}

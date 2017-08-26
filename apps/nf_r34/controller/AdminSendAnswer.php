<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');
Model('NoteAdd');

CheckAdminAccess();

if(isset($_POST['answer']) and strlen($_POST['answer']) > 0) {
    if(strlen($_POST['answer']) > 60000) {
        ViewErrorPage("Сообщение слишком длинное!");
    }
    
    NoteAdd('answers', $_POST['answer'], time());
    
    ReAddr('v=AdminAnswers');
}
else{
    ViewErrorPage("Произошла ошибка при отправке ответа.");
}

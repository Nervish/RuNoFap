<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('EditDiaryBookmark');
Model('ReAddr');

$udata = Auth();

if(isset($_GET['for']) and !empty($_GET['for']) and is_numeric($_GET['for']) and $_GET['for'] > 0) {
    if(isset($_GET['d'])) {
        if($_GET['d'] == 'add' or $_GET['d'] == 'delete') {
            EditDiaryBookmark($udata['id'], $_GET['d'], $_GET['for']);
            ReAddr('v=Diary&for='.$_GET['for']);
        }
        else{
            ViewErrorPage("Некорректная ссылка!");
        }
    }
    else{
        ViewErrorPage("Некорректная ссылка!");
    }
}
else{
    ViewErrorPage("Некорректная ссылка!");
}
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ForumDeletePost');
Model('ReAddr');

CheckAdminAccess();

if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0) {
    ForumDeletePost($_GET['id']);
}
else{
    ViewErrorPage("Некорректный идентификатор поста!");
}

ReAddr('v=Forum');
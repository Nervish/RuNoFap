<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');
Model('NoteEdit');
Model('NoteDelete');

CheckAdminAccess();

if(!empty($_POST['d'])) {
    foreach($_POST['d'] as $key=>$value) {
        NoteDelete($key);
    }
}

if(!empty($_POST['e'])) {
    foreach($_POST['e'] as $key=>$value) {
        NoteEdit($key, $_POST['note'][$key]);
    }
}

ReAddr('v=Admin');

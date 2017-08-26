<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('AddEmergencyLink');
Model('NoteDelete');
Model('ReAddr');

CheckAdminAccess();

foreach($_POST['a'] as $key=>$value) {
    AddEmergencyLink($_POST['link'][$key], $_POST['cat'][$key]);
    NoteDelete($key);
}

foreach($_POST['d'] as $key=>$value) {
    NoteDelete($key);
}

ReAddr('v=AdminEmergency');

<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');
Model('NoteDelete');

CheckAdminAccess();

foreach($_POST['d'] as $key=>$value) {
    NoteDelete($key);
}

ReAddr('v=AdminQuestions');

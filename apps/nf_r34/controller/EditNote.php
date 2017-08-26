<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('EditNote');
Model('ReAddr');

CheckAdminAccess();

$id = EditNote();
ReAddr("v=AdminEdit&target=$id");

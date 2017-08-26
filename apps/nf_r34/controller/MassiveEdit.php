<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('MassiveEdit');
Model('ReAddr');

CheckAdminAccess();

MassiveEdit($_POST);
ReAddr('', true);

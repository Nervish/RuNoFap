<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('CleanEmailDir');

CheckAdminAccess();
CleanEmailDir();

?>
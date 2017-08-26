<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('AdminEditWars');
Model('ReAddr');

CheckAdminAccess();

if(isset($_POST) and !empty($_POST)) {
    AdminEditWars($_POST);
}

ReAddr('v=AdminNoFapWars');
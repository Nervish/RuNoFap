<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('AdminEditArmies');
Model('ReAddr');

CheckAdminAccess();

if(isset($_POST) and !empty($_POST)) {
    AdminEditArmies($_POST);
}

ReAddr('v=AdminNoFapWarArmies');
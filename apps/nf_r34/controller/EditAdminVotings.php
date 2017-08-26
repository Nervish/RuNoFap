<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('EditAdminVotings');
Model('ReAddr');

CheckAdminAccess();

//var_dump($_POST);die;

if(isset($_POST) and !empty($_POST)) {
    EditAdminVotings($_POST);
}
ReAddr('v=AdminVotings');
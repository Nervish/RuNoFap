<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('Clean');
Model('ReAddr');

CheckAdminAccess();

if(isset($_GET['sort']))
    $sort = $_GET['sort'];
else
    $sort = 'time';
if(isset($_GET['ip'])) {
    Clean(ip2long($_GET['ip']));
}
ReAddr("v=AdminAccountList&sort=$sort");

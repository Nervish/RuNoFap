<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('ReAddr');

if(isset($_GET['device']) and !empty($_GET['device'])) {
    $device = $_GET['device'];
    if( ! ($device == 'desktop' or $device == 'mobile') ) {
        $device = 'desktop';
    }
    $_SESSION['device'] = $device;
}
ReAddr('', true);
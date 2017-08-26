<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');

CheckAdminAccess();

$tmp = "Links_".microtime(true).".tmp";
$fp = fopen($tmp, "w");
$result = array();
$result['links'] = array();
foreach($_POST['link'] as $key=>$link) {
    if(isset($_POST['d'][$key]) and $_POST['d'][$key] == 'on') {
        continue;
    }
    array_push($result['links'], array('link'=>$link, 'text'=>$_POST['text'][$key]));
}
if(isset($_POST['add']) and is_numeric($_POST['add']) and $_POST['add'] > 0) {
    $template = array('link'=>"", 'text'=>"");
    for($i = 0;$i < $_POST['add'];$i++) {
        array_push($result['links'], $template);
    }
}
if(fwrite($fp, json_encode($result, true))) {
    rename($tmp, "data/One/Links.dat");
}
fclose($fp);
ReAddr('v=AdminEditLinks');
<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('ReAddr');

CheckAdminAccess();

$tmp = "Files_".microtime(true).".tmp";
$fp = fopen($tmp, "w");
$result = array();
$result['files'] = array();
foreach($_POST['file'] as $key=>$file) {
    if(isset($_POST['d'][$key]) and $_POST['d'][$key] == 'on') {
        unlink($GLOBALS['files_dir']."/".$file);
        continue;
    }
    $result['files'][$file] = $_POST['text'][$key];
}
foreach($_FILES as $file) {
    if( ! $file['error']) {
        move_uploaded_file($file['tmp_name'], $GLOBALS['files_dir']."/".$file['name']);
    }
}
if(fwrite($fp, json_encode($result, true))) {
    rename($tmp, "data/One/Files.dat");
}
fclose($fp);
ReAddr('v=AdminEditFiles');

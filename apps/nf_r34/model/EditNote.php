<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('TimeCheck');

function EditNote() {
    DBConnect();
    $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE email = '".addslashes($_POST['orig_email'])."';";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        $next = true;
        $user_id = $var['id'];
        break;
    }
    if(!$next)
        ViewErrorPage("E-mail ".$_POST['orig_email']." не существует!");
    
    $short = array();
    
    if(isset($_POST['cn']) and $_POST['cn'] == 'on') {
        $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE nick = '".addslashes($_POST['nick'])."';";
        $data = Query($query);
        while($var = mysqli_fetch_assoc($data)) {
            if($var['email'] != $_POST['orig_email']) {
                ViewErrorPage("Ник ".$_POST['nick']." уже занят!");
            }
        }
        array_push($short, "nick = '".addslashes(htmlspecialchars($_POST['nick']))."'");
    }
    
    if(isset($_POST['ce']) and $_POST['ce'] == 'on') {
        array_push($short, "email = '".addslashes(htmlspecialchars($_POST['email']))."'");
    }
    
    if(isset($_POST['cr']) and $_POST['cr'] == 'on') {
        $r = TimeCheck($_POST['refresh']);
        array_push($short, "refresh = '$r'");
    }
    if(isset($_POST['ct']) and $_POST['ct'] == 'on') {
        $t = TimeCheck($_POST['time']);
        array_push($short, "time = '$t'");
    }
    if(count($short) > 0) {
        $query = "UPDATE ".$GLOBALS['db_table']." SET ".implode(", ", $short)." WHERE email = '".addslashes($_POST['orig_email'])."'";
        Query($query);
    }
    return $user_id;
}
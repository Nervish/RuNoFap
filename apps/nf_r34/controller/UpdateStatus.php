<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('Update');
Model('ReAddr');

Auth();

if(isset($_GET['s']) and !empty($_GET['s'])) {
    $status = $_GET['s'];
    if($status == 'update' and isset($_POST['date']) and !empty($_POST['date']))
        Update($_SESSION['email'], 'update', $_POST['date']);
    elseif($status == 'failtime') {
        if(isset($_POST['faildate']) and !empty($_POST['faildate'])) {
            Update($_SESSION['email'], 'failtime', $_POST['faildate']);
        }
        else{
            ViewErrorPage("Форма прислала не все данные!");
        }
    }
    else{
        Update($_SESSION['email'], 'ok');
    }
}

ReAddr('v=Profile', true);

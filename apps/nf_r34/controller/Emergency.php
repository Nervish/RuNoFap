<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmergencyAction');

if(isset($_GET['cat']) and !empty($_GET['cat'])) {
    $action = GetEmergencyAction($_GET['cat']);
}
else{
    $action = GetEmergencyAction();
}

if($action) {
    header("Location: $action");
}
else{
    ViewErrorPage("Произошла ошибка при получении данных.");
}

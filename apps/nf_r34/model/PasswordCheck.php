<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function PasswordCheck($password, $input) {
    $p = explode('$', $password);
    $salt = $p[0];
    $hash = $p[1];
    if(md5($salt.$input) == $hash) {
        return true;
    }
    else{
        return false;
    }
}

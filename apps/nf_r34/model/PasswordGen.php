<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function PasswordGen($password) {
    $rand = base64_encode(substr(md5(mt_rand()), 0, 8));
    $rand = substr(base64_encode(md5(mt_rand())), 0, 16);
    $result = "$rand$".md5($rand.$password);
    return $result;
}

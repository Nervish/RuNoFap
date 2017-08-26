<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');
Model('PasswordGen');

function Register($nick, $email, $pass, $date) {
    DBConnect();
    $realpass = PasswordGen($pass);
    $query = "SELECT * FROM ".$GLOBALS['db_table']." WHERE nick = '$nick';";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data))
        ViewErrorPage('Ник уже занят!');
    sleep(1);
    $query = "INSERT INTO ".$GLOBALS['db_table']." (nick, email, password, refresh, time, c_time, ulock) VALUES ('$nick', '$email', '$realpass', ".time().", $date, ".time().", '0')";
    Query($query);
}
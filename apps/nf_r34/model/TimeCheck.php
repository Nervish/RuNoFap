<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function TimeCheck($str) {
    $s = explode(" ", $str);
    if(empty($s[1]))
        ViewErrorPage("Неправильная дата или время!");
    $s_date = explode(".", $s[0]);
    $s_time = explode(":", $s[1]);
    for($i = 0; $i < 3; $i++) {
        if(empty($s_date[$i]) or empty($s_time[$i]))
            ViewErrorPage("Неправильная дата или время!");
    }
    if($s_time[0] < 0 || $s_time[0] > 23 || $s_time[1] < 0 || $s_time[1] > 59 || $s_time[2] < 0 || $s_time[2] > 59)
        ViewErrorPage("Неправильно указано время!");
    if($s_date[2] < 1970)
        ViewErrorPage("Неправильно указана дата");
    if($s_date[0] < 1 || $s_date[0] > 31 || $s_date[1] < 1 || $s_date[1] > 12)
        ViewErrorPage("Неправильно указана дата!");
    $t = mktime($s_time[0], $s_time[1], $s_time[2], $s_date[1], $s_date[0], $s_date[2]);
    if($t > time())
        ViewErrorPage("Будущее время?");
    if($t == 0 or $t == "")
        ViewErrorPage("Неправильная дата или время!");
    if($t < time()-$GLOBALS['max_days_at_start']*60*60*24)
        ViewErrorPage("Слишком большой срок!");
    return $t;
}
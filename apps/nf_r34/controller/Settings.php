<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('SetField');
Model('ReAddr');

if(isset($_POST['rank_system']) and strlen($_POST['rank_system']) <= 32 and array_key_exists($_POST['rank_system'], $GLOBALS['rank_systems'])) {
    $_SESSION['rank_system'] = $_POST['rank_system'];
    if(isset($_SESSION['auth']) and $_SESSION['auth']) {
        SetField($GLOBALS['db_table'], 'rank_system', $_POST['rank_system'], $_SESSION['email']);
        if(isset($_POST['allow_diary_comments'])) {
            if($_POST['allow_diary_comments'] == 'allow') {
                $a = true;
            }
            else{
                $a = false;
            }
            SetField($GLOBALS['db_table'], 'allow_diary_comments', $a, $_SESSION['email']);
        }
    }
}

ReAddr('', true);

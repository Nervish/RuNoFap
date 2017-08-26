<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('NoteAdd');

if(!isset($_SESSION['admin'])) {
    $session = new BlackSession('nf_suggest', md5($_SERVER['REMOTE_ADDR']), 'black_session/');
    if($session->Get('time') < time()-60*60*24) {
        $session->Set('time', time());
        $session->Set('add_count', 0);
        $session->Apply();
    }
    if($session->Get('add_count') >= $GLOBALS['suggest_limit'])
        ViewErrorPage("Исчерпан лимит предложений!");
}

if(!isset($_POST['link']) or !isset($_POST['comment']) or empty($_POST['link'])) {
    ViewErrorPage("Форма должна быть заполнена!");
}

$in = array('link'=>htmlspecialchars($_POST['link']), 'comment'=>htmlspecialchars($_POST['comment']));
NoteAdd('emergency_suggest', json_encode($in), time());

ViewInfoPage("Спасибо за поддержку!");

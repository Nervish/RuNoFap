<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetEmail');
Model('NoteAdd');

if(isset($_POST['msg']) and strlen($_POST['msg']) > 0) {
    if(strlen($_POST['msg']) > 10000) {
        ViewErrorPage("Сообщение слишком длинное!");
    }
    
    $session = new BlackSession('nf_mail', md5($_SERVER['REMOTE_ADDR']), 'black_session/');
    if($session->Get('time') < time()-60*60*24) {
        $session->Set('time', time());
        $session->Set('add_count', 0);
        $session->Apply();
    }
    if($session->Get('add_count') >= $GLOBALS['question_limit'])
        ViewErrorPage("Исчерпан лимит отправки сообщений для данного IP!");
    
    $msg = htmlspecialchars($_POST['msg']);
    if(isset($_SESSION['email']) and !empty($_SESSION['email'])) {
        if($udata = GetEmail($_SESSION['email'])) {
            $msg .= "\n\n<b>id: ".$udata['id']."\nnick: ".$udata['nick']."</b>";
        }
    }
    
    NoteAdd('questions', $msg, time());
    
    $session->Set('add_count', $session->Get('add_count')+1);
    $session->Apply();
    
    ViewInfoPage("Сообщение успешно отправлено.");
}
else{
    ViewErrorPage("Произошла ошибка при отправке сообщения.");
}

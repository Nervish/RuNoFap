<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('Auth');
Model('DiaryAnswer');
Model('ReAddr');


if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] > 0 and isset($_POST['answer']) and strlen($_POST['answer']) > 0 and strlen(htmlspecialchars($_POST['answer'])) <= 10000) {
    
    if($GLOBALS['diary_captcha'] or ! (isset($_SESSION['auth']) and $_SESSION['auth'])) {
        if( ! (isset($_POST['captcha']) and isset($_SESSION['captcha']) and !empty($_POST['captcha'])) ) {
            ViewErrorPage("Для постинга следует ввести капчу!");
        }
        if($_SESSION['captcha_time'] < time()-1800) {
            ViewErrorPage("Срок действия капчи истек, повторите отправку.");
        }
        if($_POST['captcha'] != $_SESSION['captcha']) {
            ViewErrorPage("Капча введена неправильно!");
        }
    }
    
    if(isset($_SESSION['auth']) and $_SESSION['auth']) {
        $email = $_SESSION['email'];
    }
    else{
        $email = 'guest';
    }
    $to = DiaryAnswer($email, $_GET['id'], $_POST['answer']);
    ReAddr("v=Diary&for=$to");
}
else{
    ViewErrorPage("Произошла ошибка при отправке ответа: данные некорректны.");
}

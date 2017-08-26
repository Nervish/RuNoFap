<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('CheckAdminAccess');
Model('WriteEmail');

CheckAdminAccess();

WriteEmail($_POST['from'], $_POST['to'], $_POST['subject'], $_POST['msg']) or ViewErrorPage("Ошибка отправки письма!");
ViewInfoPage("Сообщение успешно отправлено.");

<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function CheckAdminAccess() {
    if(!isset($_SESSION['admin']) or !$_SESSION['admin']) {
        ViewErrorPage("Доступ запрещен.");
    }
}
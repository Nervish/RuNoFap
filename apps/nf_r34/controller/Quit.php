<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('ReAddr');

session_destroy();
ReAddr('', true);

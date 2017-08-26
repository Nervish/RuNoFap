<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

function WriteEmail($from, $to, $subject, $msg) {
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: $from\r\n";
    $msg = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<title>NF</title>
</head>
<body>
".str_replace("\n", "<br />\n", $msg)."
</body>
</html>
";
    $result = mail($to, $subject, $msg, $headers);
    return $result;
}
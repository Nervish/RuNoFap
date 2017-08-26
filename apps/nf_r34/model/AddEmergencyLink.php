<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function AddEmergencyLink($slink, $cat) {
    DBConnect();
    $cat = addslashes(htmlspecialchars($cat));
    $slink = addslashes(htmlspecialchars($slink));
    $query = "INSERT INTO ".$GLOBALS['db_links']." (cat, link) VALUES ('$cat', '$slink')";
    Query($query);
}
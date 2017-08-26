<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetNoFapArmies');

$data = GetNoFapArmies();

echo "<style>\n";
foreach($data as $var) {
    echo ".war-stat__remain--army".$var['id']." {
  margin-right: 10px;
  color: ".$var['font_color_active'].";
  background-color: ".$var['bg_color_active'].";
}
.war-stat-table__item--army".$var['id']." {
  overflow: hidden;
  color: ".$var['font_color_lose'].";
  background-color: ".$var['bg_color_lose'].";
}\n";
}
echo "</style>\n";

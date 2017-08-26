<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('GetNoFapArmies');

$data = GetNoFapArmies();

echo "<style>\n";
foreach($data as $var) {
    echo ".post__flair--army".$var['id']." {
  color: ".$var['font_color_active'].";
  background-color: ".$var['bg_color_active'].";
}
.post__flair--army".$var['id']."-dead {
  color: ".$var['font_color_lose'].";
  background-color: ".$var['bg_color_lose'].";
}\n";
}
echo "</style>\n";

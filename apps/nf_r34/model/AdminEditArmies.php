<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function AdminEditArmies($temp) {
    DBConnect();
    if(isset($temp['add']) and !empty($temp['add']) and is_numeric($temp['add']) and $temp['add'] > 0) {
        $query = "INSERT INTO armies (name, bg_color_active, bg_color_lose, font_color_active, font_color_lose) VALUES ".join(',', array_fill(0, $temp['add'], "('', '', '', '', '')")).";";
        Query($query);
    }
    if(isset($temp['e']) and !empty($temp['e'])) {
        foreach($temp['e'] as $key=>$value) {
            $name = addslashes($temp['name'][$key]);
            $color1 = addslashes($temp['bg_color_active'][$key]);
            $color2 = addslashes($temp['bg_color_lose'][$key]);
            $color3 = addslashes($temp['font_color_active'][$key]);
            $color4 = addslashes($temp['font_color_lose'][$key]);
            $k = addslashes($key);
            $query = "UPDATE armies SET name = '$name', bg_color_active = '$color1', bg_color_lose = '$color2', font_color_active = '$color3', font_color_lose = '$color4' WHERE id = '$k';";
            Query($query);
        }
    }
    if(isset($temp['d']) and !empty($temp['d'])) {
        foreach($temp['d'] as $key=>$value) {
            $k = addslashes($key);
            $query = "DELETE FROM armies WHERE id = '$k';";
            Query($query);
        }
    }
}
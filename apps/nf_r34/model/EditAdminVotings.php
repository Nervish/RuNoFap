<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function EditAdminVotings($temp) {
    DBConnect();
    
    $del = array();
    if(isset($temp['d'])) {
        foreach($temp['d'] as $key=>$value) {
            array_push($del, $key);
        }
        $query = "DELETE FROM vote_systems WHERE id IN (".addslashes(join(',', $del)).");";
        Query($query);
    }
    
    $del = array();
    if(isset($temp['cd'])) {
        foreach($temp['cd'] as $key=>$value) {
            array_push($del, $key);
        }
        $query = "DELETE FROM vote_chooses WHERE id IN (".addslashes(join(',', $del)).");";
        Query($query);
    }
    
    if(isset($temp['add']) and is_numeric($temp['add']) and $temp['add'] > 0) {
        $query = "INSERT INTO vote_systems VALUES ".join(',', array_fill(0, $temp['add'], '()')).";";
        Query($query);
    }
    
    $add = array();
    if(isset($temp['add_c']) and !empty($temp['add_c'])) {
        foreach($temp['add_c'] as $key=>$value) {
            if($value) {
                $k = addslashes($key);
                $query = "INSERT INTO vote_chooses (vote_system, choose) VALUES ".join(',', array_fill(0, $value, "($k, '')")).";";
                Query($query);
            }
        }
    }
    
    if(isset($temp['name']) and !empty($temp['name'])) {
        foreach($temp['name'] as $key=>$value) {
            if(!isset($temp['e'][$key])) {
                continue;
            }
            $k = addslashes($key);
            $name = addslashes(htmlspecialchars($temp['name'][$key]));
            $descript = addslashes($temp['desc'][$key]);
            if(isset($temp['mult'][$key])) {
                $mult = 1;
            }
            else{
                $mult = 0;
            }
            if(isset($temp['active'][$key])) {
                $active = 1;
            }
            else{
                $active = 0;
            }
            $query = "UPDATE vote_systems SET name='$name', descript='$descript', mult='$mult', active='$active' WHERE id = '$k';";
            Query($query);
        }
    }
    
    if(isset($temp['choose']) and !empty($temp['choose'])) {
        foreach($temp['choose'] as $key=>$value) {
            if(!isset($temp['ce'][$key])) {
                continue;
            }
            $k = addslashes($key);
            $choose = addslashes($value);
            $query = "UPDATE vote_chooses SET choose='$choose' WHERE id = '$k';";
            Query($query);
        }
    }
}
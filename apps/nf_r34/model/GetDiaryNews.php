<?php

if(!isset($GLOBALS['rw_fmeow'])) die();

Model('DBConnect');
Model('Query');

function GetDiaryNews() {
    DBConnect();
    $result = array();
    $tmp = array();
    $times = array();
    
    $query = "SELECT diary.author_id, UNIX_TIMESTAMP(diary.time) AS time FROM diary, (SELECT author_id FROM diary WHERE public AND answ = 0 GROUP BY author_id) t WHERE t.author_id = diary.author_id AND public AND answ = 0 ORDER BY diary.id DESC LIMIT 0,".$GLOBALS['diary_news'].";";
    $data = Query($query);
    
    while($var = mysqli_fetch_assoc($data)) {
        $tmp[] = $var['author_id'];
        $times[$var['author_id']] = $var['time'];
    }

    $query = "SELECT id, nick, time FROM nofap WHERE id IN (".implode(',', $tmp).");";
    $data = Query($query);
    while($var = mysqli_fetch_assoc($data)) {
        $tmp = $var;
        $tmp['note_time'] = $times[$var['id']];
        $result[] = $tmp;
    }

    for($i=1; $i<count($result);$i++) {
        for($j=$i;$j>0;$j--) {
            if($result[$j]['note_time'] > $result[$j-1]['note_time']) {
                $tmp = $result[$j-1];
                $result[$j-1] = $result[$j];
                $result[$j] = $tmp;
            }
        }
    }

    return $result;
}

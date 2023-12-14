<?php
//функция поиска значения по ключу в массиве
function get_value_by_key($array,$key) {
    $res = '';
    foreach($array as $k=>$each) {
        if($k==$key) {
            $res = $each;
        }
    }
    return $res;
}

echo get_value_by_key(['name' => 'Alex', 'age' => 31], 'name');
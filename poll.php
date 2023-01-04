<?php

function openPollObject($name): array {
    $str = file_get_contents($name);
    $arr = explode('|[1]|', $str);
    $obj = [];
    foreach ($arr as $line) {
        $div = explode('|[>]|', $line);
        $prop = $div[0];
        $val = $div[1];
        $obj[$prop] = $val;
    }
    
    return $obj;
}

$category = $_REQUEST['id'];
$selection = $_REQUEST['value'];

$selRating = file_get_contents($selection.'/rating');
$selRating += 1;
file_put_contents($selection.'/rating', $selRating);
chmod($selection.'/rating', 0777);

$openPoll = openPollObject($category);
$pollOptions = $openPoll['index'];
$pollRange = $openPoll['range'];
$pollIndex = explode(';', $pollOptions);
$poll = [];
foreach ($pollIndex as $key=>$value) {
    $poll[$value] = file_get_contents($value.'/rating');
}
arsort($poll, SORT_NUMERIC);
$max = max($poll);
$min = min($poll);
$diff = $max - $min;
if ($diff >= $pollRange) {
    unset($poll[array_search($min, $poll)]);
}
$index = array_keys($poll);
$list = implode(';', $index);
$string = 'index|[>]|'.$list.'|[1]|range|[>]|'.$pollRange;
file_put_contents($category, $string);
chmod($category, 0777);

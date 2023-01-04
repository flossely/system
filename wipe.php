<?php

$part = $_REQUEST['part'];
$from = $_REQUEST['from'];
$sep = $_REQUEST['sep'];

$dir = '.';

if ($from == 'right' || $from == 'end' || $from == 'trail' || $from == 'trailing') {
    $list = str_replace($dir.'/','',(glob($dir.'/*'.$sep.$part)));
} elseif ($from == 'left' || $from == 'start' || $from == 'lead' || $from == 'leading') {
    $list = str_replace($dir.'/','',(glob($dir.'/'.$part.$sep.'*')));
}

if ($part != '') {
    foreach ($list as $key=>$value) {
        chmod($value, 0777);
        unlink($value);
    }
}

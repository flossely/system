<?php

function sprArr($name): array {
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

function getLocaleData($id) {
    if (file_exists($id.'/locale')) {
        $localeID = file_get_contents($id.'/locale');
        $localeArr = sprArr($localeID.'.locale');
        $zoneValue = $localeArr['curval'];
    } else {
        $zoneValue = 1;
    }
    
    return $zoneValue;
}

if (file_exists('money')) {
    $amountFile = file_get_contents('money');
    if (is_numeric($amountFile)) {
        $amount = $amountFile;
    } else {
        $amount = 0;
    }
} else {
    $amount = 0;
}

$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
$count = count($list);
if ($count > 0) {
    $content = $amount / $count;

    foreach ($list as $key=>$value) {
        $zone1 = getLocaleData('.');
        $zone2 = getLocaleData($value);
        
        $zoneCourse = $zone1 / $zone2;
        $summary = $content * $zoneCourse;
    
        file_put_contents($value.'/money', $summary);
        chmod($value.'/money', 0777);
    }
}

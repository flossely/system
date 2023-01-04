<?php

function parseArrayFile($name): array {
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

function parseGetData($data): array {
    $parse = explode('|[1]|', $data);
    $arr = [];
    foreach ($parse as $load) {
        $line = explode('|[>]|', $load);
        $prop = $line[0];
        $value = $line[1];
        $arr[$prop] = $value;
    }
    
    return $arr;
}

$paradigm = ($_REQUEST['paradigm']) ? $_REQUEST['paradigm'] : 'system';
$paradigmData = parseArrayFile($paradigm.'.par');
if (file_exists('year')) {
    $today = file_get_contents('year');
} else {
    $today = $paradigmData['default_year'];
}
$lazones = str_replace('./','',(glob('./*.locale')));
if (file_exists('locale')) {
    $locale = file_get_contents('locale');
} else {
    $locale = basename(array_key_first($lazones), '.locale');
}
$lingua = $locale;

if (file_exists('money')) {
    $amountFile = file_get_contents('money');
    if (is_numeric($amountFile)) {
        $amount = $amountFile;
    } else {
        $amount = $paradigmData['default_money'];
    }
} else {
    $amount = $paradigmData['default_money'];
}

$dirToUse = '.';
$listAllProfiles = str_replace($dirToUse.'/','',(glob($dirToUse.'/*', GLOB_ONLYDIR)));
$countProfiles = count($listAllProfiles);

if ($countProfiles > 0) {
    $redistributed = $amount / $countProfiles;

    foreach ($listAllProfiles as $onbyProfile) {
        file_put_contents($onbyProfile.'/born', $today);
        chmod($onbyProfile.'/born', 0777);
        if (isset($paradigmData['starting_rating'])) {
            file_put_contents($onbyProfile.'/rating', $paradigmData['starting_rating']);
            chmod($onbyProfile.'/rating', 0777);
        }
        if (isset($paradigmData['starting_mode'])) {
            file_put_contents($onbyProfile.'/mode', $paradigmData['starting_mode']);
            chmod($onbyProfile.'/mode', 0777);
        }
        if (isset($paradigmData['starting_coord'])) {
            file_put_contents($onbyProfile.'/coord', $paradigmData['starting_coord']);
            chmod($onbyProfile.'/coord', 0777);
        }
        if (isset($paradigmData['starting_score'])) {
            file_put_contents($onbyProfile.'/score', $paradigmData['starting_score']);
            chmod($onbyProfile.'/score', 0777);
        }
        if ((isset($paradigmData['redistribute'])) && ($paradigmData['redistribute'] != false)) {
            file_put_contents($onbyProfile.'/money', $redistributed);
            chmod($onbyProfile.'/money', 0777);
        } else {
            if (isset($paradigmData['starting_money'])) {
                file_put_contents($onbyProfile.'/money', $paradigmData['starting_money']);
                chmod($onbyProfile.'/money', 0777);
            }
        }
    }
}

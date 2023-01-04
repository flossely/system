<?php

$startDir = '.';
include 'basefunc.php';
include 'stat.php';

$baseLatin =
[
    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
];
$numbers =
[
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
];

if (file_exists('paradigm')) {
    $thdirParadigm = file_get_contents('paradigm');
} else {
    $thdirParadigm = 'system';
}
$thdirParadigmData = getArrFromFile($thdirParadigm.'.par');
if (file_exists('year')) {
    $thdirToday = file_get_contents('year');
} else {
    $thdirToday = $thdirParadigmData['default_year'];
}
$thdirZoneList = str_replace($startDir.'/','',(glob($startDir.'/*.locale')));
if (file_exists("locale")) {
    $locale = file_get_contents("locale");
} else {
    $locale = basename($thdirZoneList[0], '.locale');
    file_put_contents("locale", $locale);
    chmod("locale", 0777);
}
$lingua = $locale;
$thdirZone = localeArr();
$thdirZoneCur = $thdirZone[$lingua][1];
$thdirZoneVal = $thdirZone[$lingua][0];
$thdirZoneMtr = $thdirZone[$lingua][2];

$diction = [];
include $lingua.'.diction.php';
include $lingua.'.metro.php';

if (file_exists($lingua.'.deg')) {
    $degOpen = file_get_contents($lingua.'.deg');
    if ($degOpen != '') {
        $degSign = ' '.$degOpen;
    } else {
        $degSign = '';
    }
} else {
    $degSign = '';
}

define('NULLPKG', [
    'author' => '',
    'avatar' => 'pkg',
    'version' => '1.0',
    'branch' => '',
    'born' => '',
    'description' => '',
    'title' => '',
    'type' => 'Package'
]);

if (file_exists('system.info')) {
    $currentSystem = file_get_contents('system.info');
    if ($currentSystem != '') {
        $syspkg = getArrFromFile($currentSystem.'.pkg');
    } else {
        $syspkg = NULLPKG;
    }
} else {
    $syspkg = NULLPKG;
}

if (file_exists('style.info')) {
    $currentStyle = file_get_contents('style.info');
    if ($currentStyle != '') {
        $stylepkg = getArrFromFile($currentStyle.'.pkg');
    } else {
        $stylepkg = NULLPKG;
    }
} else {
    $stylepkg = NULLPKG;
}

$effects = str_replace($startDir.'/','',(glob($startDir.'/*.wav')));
$websiteID = basename(__DIR__);

$profiles = str_replace($startDir.'/','',(glob($startDir.'/*', GLOB_ONLYDIR)));
foreach ($profiles as $key=>$value) {
    if (isEntity($value) === false) {
        unset($profiles[array_search($value, $profiles)]);
    } else {
        $profRating = file_get_contents($value.'/rating');
        if ($profRating < 0) {
            unset($profiles[array_search($value, $profiles)]);
        }
    }
}

if (file_exists('name')) {
    $websiteTitleFile = file_get_contents('name');
    if ($websiteTitleFile != '') {
        $websiteTitle = $websiteTitleFile;
    } else {
        $websiteTitle = $websiteID;
    }
} else {
    $websiteTitle = $websiteID;
}

if (file_exists('mode')) {
    $appModeFile = file_get_contents('mode');
    if (is_numeric($appModeFile)) {
        $appMode = $appModeFile;
    } else {
        $appMode = 0;
    }
} else {
    $appMode = 0;
}

include 'profile.php';

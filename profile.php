<?php

if (file_exists('rating')) {
    $thdirRatingOpen = file_get_contents('rating');
    $thdirRating = ($thdirRatingOpen != '') ? $thdirRatingOpen : $thdirParadigmData['default_rating'];
} else {
    $thdirRating = $thdirParadigmData['default_rating'];
}
if (file_exists('mode')) {
    $thdirModeOpen = file_get_contents('mode');
    $thdirMode = ($thdirModeOpen != '') ? $thdirModeOpen : $thdirParadigmData['default_mode'];
} else {
    $thdirMode = $thdirParadigmData['default_mode'];
}
if (file_exists('score')) {
    $thdirScoreOpen = file_get_contents('score');
    $thdirScore = ($thdirScoreOpen != '') ? $thdirScoreOpen : $thdirParadigmData['default_score'];
} else {
    $thdirScore = $thdirParadigmData['default_score'];
}
if (file_exists('money')) {
    $thdirMoneyOpen = file_get_contents('money');
    $thdirMoney = ($thdirMoneyOpen != '') ? $thdirMoneyOpen : $thdirParadigmData['default_money'];
} else {
    $thdirMoney = $thdirParadigmData['default_money'];
}
if (file_exists($locale.'.cur')) {
    $thdirEconZoneSign = file_get_contents($locale.'.cur');
} else {
    $thdirEconZoneSign = '$';
}
if (file_exists($locale.'.curval')) {
    $thdirEconZoneVal = file_get_contents($locale.'.curval');
} else {
    $thdirEconZoneVal = 1;
}
if (file_exists('coord')) {
    $thdirCoordOpen = file_get_contents('coord');
    $thdirCoord = ($thdirCoordOpen != '') ? $thdirCoordOpen : $thdirParadigmData['default_coord'];
} else {
    $thdirCoord = $thdirParadigmData['default_coord'];
}
if (file_exists('born')) {
    $thdirBornOpen = file_get_contents('born');
    $thdirBorn = ($thdirBornOpen != '') ? $thdirBornOpen : $thdirParadigmData['default_year'];
} else {
    $thdirBorn = $thdirParadigmData['default_year'];
}

if ($thdirMode > 0) {
    $thdirModeSign = '+@';
} elseif ($thdirMode < 0) {
    $thdirModeSign = '-@';
} else {
    $thdirModeSign = '@';
}
$thdirCoordVar = explode(';', $thdirCoord);
if (is_numeric($thdirCoordVar[0])) {
    $thdirCoordX = $thdirCoordVar[0];
} else {
    $thdirCoordX = 0;
}
if (is_numeric($thdirCoordVar[1])) {
    $thdirCoordY = $thdirCoordVar[1];
} else {
    $thdirCoordY = 0;
}
if (is_numeric($thdirCoordVar[2])) {
    $thdirCoordZ = $thdirCoordVar[2];
} else {
    $thdirCoordZ = 0;
}

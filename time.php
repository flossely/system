<?php

define('DATE_FORMAT', 'd/m/Y');
define('TIME_FORMAT', 'H:i:s');

if (file_exists('timezone')) {
    $timezoneFile = file_get_contents('timezone');
    $timezone = ($timezoneFile != '') ? $timezoneFile : 'UTC';
} else {
    $timezone = 'UTC';
}

if (file_exists('timedisp')) {
    $timedispFile = file_get_contents('timedisp');
    $timedisp = ($timedispFile != '') ? $timedispFile : 'time';
} else {
    $timedisp = 'time';
}

if (file_exists('dateformat')) {
    $dateformatFile = file_get_contents('dateformat');
    $dateformat = ($dateformatFile != '') ? $dateformatFile : DATE_FORMAT;
} else {
    $dateformat = DATE_FORMAT;
}

if (file_exists('timeformat')) {
    $timeformatFile = file_get_contents('timeformat');
    $timeformat = ($timeformatFile != '') ? $timeformatFile : TIME_FORMAT;
} else {
    $timeformat = TIME_FORMAT;
}

date_default_timezone_set($timezone);

if ($timedisp == 'date') {
    echo date($dateformat);
} else {
    echo date($timeformat);
}

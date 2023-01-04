<?php

$extension = $_REQUEST['ext'];
$content = $_POST['content'];

if (file_exists("locale")) {
    $localeOpen = file_get_contents("locale");
    $locale = ($localeOpen != "") ? $localeOpen : "en";
} else {
    $locale = "en";
}
$lingua = $locale;

$dictus = [];
include $lingua.'.dictus.php';

$name = $dictus[$lingua]['alphabet'][rand(0, count($dictus[$lingua]['alphabet']) - 1)];

if (file_exists($name.'.'.$extension)) {
    $name = $dictus[$lingua]['alphabet'][rand(0, count($dictus[$lingua]['alphabet']) - 1)];
}

if (!file_exists($name.'.'.$extension)) {
    file_put_contents($name.'.'.$extension, $content);
    chmod($name.'.'.$extension, 0777);
}

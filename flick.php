<?php

function correct($num) {
    if (strlen($num) < 2) {
        return 0 . $num;
    } else {
        return $num;
    }
}

$red = correct(dechex(rand(0, 255)));
$green = correct(dechex(rand(0, 255)));
$blue = correct(dechex(rand(0, 255)));

echo $red . $green . $blue;

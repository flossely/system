<?php

$getMoney = file_get_contents('money');

$input = $_REQUEST['i'];
$output = $_REQUEST['o'];

if (file_exists($input.'.curval')) {
    if (is_numeric(file_get_contents($input.'.curval'))) {
        $inputEconVal = file_get_contents($input.'.curval');
    } else {
        $inputEconVal = 1;
    }
} else {
    $inputEconVal = 1;
}
if (file_exists($output.'.curval')) {
    if (is_numeric(file_get_contents($output.'.curval'))) {
        $outputEconVal = file_get_contents($output.'.curval');
    } else {
        $outputEconVal = 1;
    }
} else {
    $outputEconVal = 1;
}

$diffEcon = $inputEconVal / $outputEconVal;
$moneyCalc = $getMoney * $diffEcon;

file_put_contents('money', $moneyCalc);
chmod('money', 0777);


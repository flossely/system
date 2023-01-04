<?php

$subActions = ['pass', 'sex'];
$subActionCount = count($subActions);
$subAction = $subActions[rand(0, $subActionCount - 1)];

if ($subAction == 'pass') {
    $printString = $turnNum." : ".$subFullName.' '.$diction[$proLingo]['action']['200']."<br>";
} elseif ($subAction == 'sex') {
    $subRating += $objArousal;
    $objRating += $subArousal;
    $printString = $turnNum.' : '.$subFullName.' ('.$subRating.') '.$diction[$proLingo]['action']['666'].' '.$objFullName.' ('.$objRating.')<br>';
}

<?php

$subActions = ["pass"];
$subActionCount = count($subActions);
$subAction = $subActions[rand(0, $subActionCount - 1)];

if ($subAction == "pass") {
    $printString = $turnNum." : ".$subFullName.' '.$diction[$proLingo]['action']['200']."<br>";
}

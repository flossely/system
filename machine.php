<?php

if (file_exists('paradigm')) {
    $thisParadigm = file_get_contents('paradigm');
} else {
    $thisParadigm = 'system';
}
$thisParadigmData = getArrayFromFile($thisParadigm.'.par');

if (file_exists('year')) {
    $yearToday = file_get_contents('year');
} else {
    $yearToday = $thisParadigmData['default_year'];
}
if (file_exists('money')) {
    $proMoney = file_get_contents('money');
} else {
    $proMoney = $thisParadigmData['default_money'];
}
$zoneList = str_replace('./','',(glob('./*.locale')));
if (file_exists('locale')) {
    $proLingo = file_get_contents('locale');
} else {
    $proLingo = basename(array_key_first($zoneList), '.locale');
}
$proZone = getArrayFromFile($proLingo.'.locale');
$diction = [];
include $proLingo.'.diction.php';

$subRand = rand(0,$last);
$subID = $subRand;
$sub = $index[$subRand];
$subRating = file_get_contents($sub.'/rating');
$subMode = file_get_contents($sub.'/mode');
$subCoord = file_get_contents($sub.'/coord');
$subScore = file_get_contents($sub.'/score');
$subMoney = file_get_contents($sub.'/money');
$subBorn = file_get_contents($sub.'/born');
if (file_exists($sub.'/locale')) {
    $subLingo = file_get_contents($sub.'/locale');
} else {
    $subLingo = $proLingo;
}
$subZone = getArrayFromFile($subLingo.'.locale');
$subAge = age($subBorn, $yearToday);
$subX = coordArr($subCoord)['x'];
$subY = coordArr($subCoord)['y'];
$subZ = coordArr($subCoord)['z'];
$subRatio = getFractionFromFile($sub.'/ratio');
$subBshp = getLevelNum($sub.'/bshp');
$subFshp = getLevelNum($sub.'/fshp');

$objRand = rand(0,$last);
$objID = $objRand;
$obj = $index[$objRand];
$objRating = file_get_contents($obj.'/rating');
$objMode = file_get_contents($obj.'/mode');
$objCoord = file_get_contents($obj.'/coord');
$objScore = file_get_contents($obj.'/score');
$objMoney = file_get_contents($obj.'/money');
$objBorn = file_get_contents($obj.'/born');
if (file_exists($obj.'/locale')) {
    $objLingo = file_get_contents($obj.'/locale');
} else {
    $objLingo = $proLingo;
}
$objZone = getArrayFromFile($objLingo.'.locale');
$objAge = age($objBorn, $yearToday);
$objX = coordArr($objCoord)['x'];
$objY = coordArr($objCoord)['y'];
$objZ = coordArr($objCoord)['z'];
$objRatio = getFractionFromFile($obj.'/ratio');
$objBshp = getLevelNum($obj.'/bshp');
$objFshp = getLevelNum($obj.'/fshp');

$subMove = getSpeed($subRating);
$subReach = getReach($subRating);
$objMove = getSpeed($objRating);
$objReach = getReach($objRating);
$turnNum = turnFormat($thisParadigm, $yearToday);
$subFullName = useFullName($sub);
$objFullName = useFullName($obj);

$subModeDiff = compareModes($subMode, $objMode);
$objModeDiff = compareModes($objMode, $subMode);

include 'pre.'.$thisParadigm.'.parfunc.php';
if (self($sub, $obj)) {
    if (alive($subRating)) {
        include 'ifself.'.$thisParadigm.'.parfunc.php';
    } else {
        $printString = $turnNum.' : '.$subFullName.' '.$diction[$proLingo]['action']['500'].'<br>';
    }
} else {
    if (alive($subRating)) {
        if (alive($objRating)) {
	        if (reach($subX, $subY, $subZ, $objX, $objY, $objZ, $subReach)) {
	            include 'on'.relate($subMode, $objMode).'.'.$thisParadigm.'.parfunc.php';
	        } else {
	            include 'ifnotreach.'.$thisParadigm.'.parfunc.php';
		    }
        } else {
	        include 'ifobjdead.'.$thisParadigm.'.parfunc.php';
        }
    } else {
        $printString = $turnNum.' : '.$subFullName.' '.$diction[$proLingo]['action']['500'].'<br>';
    }
}
echo $printString;

if (file_exists('log.mo')) {
    if (!file_exists('.log')) {
        mkdir('.log');
        chmod('.log', 0777);
    }
        
    file_put_contents('.log/'.$yearToday.'.log', $printString);
    chmod('.log/'.$yearToday.'.log', 0777);
}

$yearToday += 1;
include 'post.'.$thisParadigm.'.parfunc.php';

file_put_contents('year', $yearToday);
chmod('year', 0777);
file_put_contents('locale', $proLingo);
chmod('locale', 0777);
file_put_contents('money', $proMoney);
chmod('money', 0777);

file_put_contents($obj.'/coord', $objX.';'.$objY.';'.$objZ);
chmod($obj.'/coord', 0777);
file_put_contents($obj.'/rating', $objRating);
chmod($obj.'/rating', 0777);
file_put_contents($obj.'/mode', $objMode);
chmod($obj.'/mode', 0777);
file_put_contents($obj.'/score', $objScore);
chmod($obj.'/score', 0777);
file_put_contents($obj.'/money', $objMoney);
chmod($obj.'/money', 0777);
file_put_contents($obj.'/locale', $objLingo);
chmod($obj.'/locale', 0777);
file_put_contents($obj.'/born', $objBorn);
chmod($obj.'/born', 0777);

file_put_contents($sub.'/coord', $subX.';'.$subY.';'.$subZ);
chmod($sub.'/coord', 0777);
file_put_contents($sub.'/rating', $subRating);
chmod($sub.'/rating', 0777);
file_put_contents($sub.'/mode', $subMode);
chmod($sub.'/mode', 0777);
file_put_contents($sub.'/score', $subScore);
chmod($sub.'/score', 0777);
file_put_contents($sub.'/money', $subMoney);
chmod($sub.'/money', 0777);
file_put_contents($sub.'/locale', $subLingo);
chmod($sub.'/locale', 0777);
file_put_contents($sub.'/born', $subBorn);
chmod($sub.'/born', 0777);

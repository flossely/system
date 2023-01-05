<?php

$subActions = ['pass', 'sex', 'trade'];
$subActionCount = count($subActions);
$subAction = $subActions[rand(0, $subActionCount - 1)];

if ($subAction == 'pass') {
    $printString = $turnNum." : ".$subFullName.' '.$diction[$proLingo]['action']['200']."<br>";
} elseif ($subAction == 'sex') {
    $subRating += $objArousal;
    $objRating += $subArousal;
    $printString = $turnNum.' : '.$subFullName.' ('.$subRating.') '.$diction[$proLingo]['action']['666'].' '.$objFullName.' ('.$objRating.')<br>';
} elseif ($subAction == 'trade') {
    $econArray = getZonesData($zoneList);
    $leftCurrency = $econArray['signs'][$objLingo];
    $rightCurrency = $econArray['signs'][$subLingo];
    $leftWriteSide = $econArray['sides'][$objLingo];
    $rightWriteSide = $econArray['sides'][$subLingo];
    $leftValue = $econArray['values'][$objLingo];
    $rightValue = $econArray['values'][$subLingo];
    
    $leftExchRate = $rightValue / $leftValue;
    $rightExchRate = $leftValue / $rightValue;
    
    if ($objHold !== null) {
        $leftObjPrice = $objHold['price'] * $leftExchRate;
        $rightObjPrice = $objHold['price'] * $rightExchRate;
        
        if (!file_exists($sub.'/'.$objHold['object_file'])) {
            if ($subMoney >= $rightObjPrice) {
                $objMoney += $leftObjPrice;
                $subMoney -= $rightObjPrice;
                
                chmod($obj.'/'.$objHold['object_file'], 0777);
                rename($obj.'/'.$objHold['object_file'], $sub.'/'.$objHold['object_file']);
                
                if ($rightWriteSide != 0) {
                    $scribeSide = $rightObjPrice.' '.$rightCurrency;
                } else {
                    $scribeSide = $rightCurrency.$rightObjPrice;
                }
                
                $printString = $turnNum.' : '.$objFullName.' DEBIT '.$objHold['name'].' '.$subFullName.' CREDIT '.$scribeSide.'<br>';
            } else {
                $printString = $turnNum.' : '.$diction[$proLingo]['transaction']['51'].'<br>';
            }
        } else {
            $printString = $turnNum.' : '.$diction[$proLingo]['transaction']['12'].'<br>';
        }
    } else {
        $printString = $turnNum.' : '.$diction[$proLingo]['transaction']['30'].'<br>';
    }
}

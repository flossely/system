<?php

$action = $_REQUEST['action'];
$path = ($_REQUEST['path']) ? $_REQUEST['path'] : '.';
$class = $_REQUEST['class'];
$name = $_REQUEST['name'];
$input = $_POST['input'];

if ($action == 'create') {
    file_put_contents($path.'/'.$name.'.'.$class.'.obj', $input);
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
} elseif ($action == 'attach') {
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
    $outputFile = file_get_contents($path.'/'.$name.'.'.$class.'.obj');
    $outputArr = explode('|[1]|', $outputFile);
    $inputArr = explode('|[1]|', $input);
    foreach ($inputArr as $item) {
        $itemPart = explode('|[>]|', $item);
        $itemProp = $itemPart[0];
        $itemValue = $itemPart[1];
        $outputArr[$itemProp] = $itemValue;
    }
    $outputStr = '';
    foreach ($outputArr as $key=>$value) {
        $outputStr .= $key . '|[>]|' . $value . '|[1]|';
    }
    $outputRep = substr_replace($outputStr, '', -5);
    file_put_contents($path.'/'.$name.'.'.$class.'.obj', $outputRep);
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
} elseif ($action == 'detach') {
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
    $outputFile = file_get_contents($path.'/'.$name.'.'.$class.'.obj');
    $outputArr = explode('|[1]|', $outputFile);
    $inputArr = explode('|[1]|', $input);
    foreach ($inputArr as $item) {
        $itemPart = explode('|[>]|', $item);
        $itemProp = $itemPart[0];
        $itemValue = $itemPart[1];
        unset($outputArr[$itemProp]);
    }
    $outputStr = '';
    foreach ($outputArr as $key=>$value) {
        $outputStr .= $key . '|[>]|' . $value . '|[1]|';
    }
    $outputRep = substr_replace($outputStr, '', -5);
    file_put_contents($path.'/'.$name.'.'.$class.'.obj', $outputRep);
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
} elseif ($action == 'delete') {
    chmod($path.'/'.$name.'.'.$class.'.obj', 0777);
    unlink($path.'/'.$name.'.'.$class.'.obj');
}

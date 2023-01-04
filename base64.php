<?php
$key = $_REQUEST['key'];
$input = $_REQUEST['input'];
$output = $_REQUEST['output'];
if ($key == 'in') {
    $imagedata = file_get_contents($input);
    $base64 = base64_encode($imagedata);
    file_put_contents($output, $base64);
    chmod($output, 0777);
} elseif ($key == 'out') {
    $base64 = file_get_contents($input);
    $rawdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
    file_put_contents($output, $rawdata);
    chmod($output, 0777);
}

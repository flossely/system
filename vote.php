<?php
$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
if (file_exists($id.'/rating')) {
    $content = file_get_contents($id.'/rating');
} else {
    $content = 0;
}
if ($key == 'up') {
    $content += 1;
} elseif ($key == 'down') {
    $content -= 1;
}
file_put_contents($id.'/rating', $content);
chmod($id.'/rating', 0777);

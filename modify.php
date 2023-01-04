<?php
$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
if (file_exists($id.'/mode')) {
    $content = file_get_contents($id.'/mode');
} else {
    $content = 0;
}
if ($key == 'up') {
    $content += 1;
} elseif ($key == 'down') {
    $content -= 1;
}
if ($content > 0) {
    $content = 1;
} elseif ($content < 0) {
    $content = -1;
} else {
    $content = 0;
}
file_put_contents($id.'/mode', $content);
chmod($id.'/mode', 0777);

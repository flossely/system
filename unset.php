<?php
$name = $_REQUEST['name'];
if (is_dir($name)) {
    exec('chmod -R 777 .');
    exec('rm -rf '.$name);
} else {
    chmod($name, 0777);
    unlink($name);
}
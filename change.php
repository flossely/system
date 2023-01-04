<?php
$name = $_REQUEST['name'];
$to = $_REQUEST['to'];
rename($name, $to);
chmod($to, 0777);
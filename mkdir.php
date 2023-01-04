<?php
$name = $_REQUEST['name'];
mkdir($name);
chmod($name, 0777);
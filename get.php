<?php

function parseArrayFile($name): array {
    $str = file_get_contents($name);
    $arr = explode('|[1]|', $str);
    $obj = [];
    foreach ($arr as $line) {
        $div = explode('|[>]|', $line);
        $prop = $div[0];
        $val = $div[1];
        $obj[$prop] = $val;
    }
    
    return $obj;
}

$action = $_REQUEST['key'];
$host = ($_REQUEST['host']) ? $_REQUEST['host'] : 'https://github.com';
$pkg = $_REQUEST['pkg'];
$repo = $_REQUEST['repo'];
$branch = ($_REQUEST['branch']) ? $_REQUEST['branch'] : '';
$user = $_REQUEST['user'];

if ($action == 'i' || $action == 's' || $action == 'o') {
    if ($pkg == "from" && $repo != "" && $user != "") {
        if (file_exists($repo.'.pkg')) {
            $package = parseArrayFile($repo.'.pkg');
            $list = $package['files'];
            $files = explode(';', $list);
            foreach ($files as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
            chmod($repo.'.pkg', 0777);
            unlink($repo.'.pkg');
        }
        
        if (file_exists('backup')) {
            $backlist = file_get_contents('backup');
            $backup = explode(';', $backlist);
            foreach ($backup as $key=>$file) {
                if (file_exists($file)) {
                    rename($file, $file.'.bak');
                    chmod($file.'.bak', 0777);
                }
            }
        }
        
        if (file_exists($repo)) {
            chmod($repo, 0777);
            rename($repo, $repo.'.d');
        }
        
        $request = $host.'/'.$user.'/'.$repo;
        if ($branch != '') {
            exec('git clone -b '.$branch.' '.$request);
        } else {
            exec('git clone '.$request);
        }
        chmod($repo, 0777);
        
        exec('mv '.$repo.'/* $PWD');
        exec('chmod -R 777 .');
        exec('rm -rf '.$repo);
        
        if (file_exists($repo.'.d')) {
            chmod($repo.'.d', 0777);
            rename($repo.'.d', $repo);
        }
        
        if (file_exists('ignore')) {
            $ignorlist = file_get_contents('ignore');
            $ignore = explode(';', $ignorlist);
            foreach ($ignore as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
        }
        
        foreach ($backup as $key=>$file) {
            if (file_exists($file.'.bak')) {
                rename($file.'.bak', $file);
                chmod($file, 0777);
            }
        }
    }
} elseif ($action == 'r' || $action == 'p' || $action == 'm') {
    if ($pkg != "" && $repo != "" && $user != "") {
        if (file_exists($pkg.'.pkg')) {
            $package = parseArrayFile($pkg.'.pkg');
            $list = $package['files'];
            $files = explode(";", $list);
            foreach ($files as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
            chmod($pkg.'.pkg', 0777);
            unlink($pkg.'.pkg');
        }
        header('Location: get.php?key=i&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    }
} elseif ($action == 'd' || $action == 'u' || $action == 'x') {
    if ($pkg != "" && $repo == 'from' && $user == 'here') {
        if (file_exists($pkg.'.pkg')) {
            $package = parseArrayFile($pkg.'.pkg');
            $list = $package['files'];
            $files = explode(";", $list);
            foreach ($files as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
            chmod($pkg.'.pkg', 0777);
            unlink($pkg.'.pkg');
        }
    }
}

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

function parseGetData($data): array {
    $parse = explode('|[1]|', $data);
    $arr = [];
    foreach ($parse as $load) {
        $line = explode('|[>]|', $load);
        $prop = $line[0];
        $value = $line[1];
        $arr[$prop] = $value;
    }
    
    return $arr;
}

function localeArr() {
    $dir = '.';
    $list = str_replace($dir.'/','',(glob($dir.'/*.locale')));
    $arr = [];
    
    foreach ($list as $key=>$value) {
        $localeID = basename($value, '.locale');
        $localeData = getArrFromFile($value);
        $arr[] = $localeID;
        
        foreach ($localeData as $entry=>$data) {
            if ($entry == 'cur' || $entry == 'angsym') {
                file_put_contents($localeID.'.'.$entry, $data);
                chmod($localeID.'.'.$entry, 0777);
            } elseif ($entry == 'mtr' || $entry == 'angdig' || $entry == 'curside') {
                if (is_numeric($data)) {
                    file_put_contents($localeID.'.'.$entry, $data);
                    chmod($localeID.'.'.$entry, 0777);
                } else {
                    file_put_contents($localeID.'.'.$entry, 0);
                    chmod($localeID.'.'.$entry, 0777);
                }
            } else {
                if (is_numeric($data)) {
                    file_put_contents($localeID.'.'.$entry, $data);
                    chmod($localeID.'.'.$entry, 0777);
                } else {
                    file_put_contents($localeID.'.'.$entry, 1);
                    chmod($localeID.'.'.$entry, 0777);
                }
            }
        }
    }
    
    return $arr;
}

function localeGen($id) {
    $dir = '.';
    $list = str_replace($dir.'/','',(glob($dir.'/*.locale')));
    $arr = [];
    
    foreach ($list as $key=>$value) {
        $localeID = basename($value, '.locale');
        $localeData = getArrFromFile($value);
        $arr[] = $localeID;
        
        foreach ($localeData as $entry=>$data) {
            if ($entry == 'cur' || $entry == 'angsym') {
                file_put_contents($id.'/'.$localeID.'.'.$entry, $data);
                chmod($id.'/'.$localeID.'.'.$entry, 0777);
            } elseif ($entry == 'mtr' || $entry == 'angdig' || $entry == 'curside') {
                if (is_numeric($data)) {
                    file_put_contents($id.'/'.$localeID.'.'.$entry, $data);
                    chmod($id.'/'.$localeID.'.'.$entry, 0777);
                } else {
                    file_put_contents($id.'/'.$localeID.'.'.$entry, 0);
                    chmod($id.'/'.$localeID.'.'.$entry, 0777);
                }
            } else {
                if (is_numeric($data)) {
                    file_put_contents($id.'/'.$localeID.'.'.$entry, $data);
                    chmod($id.'/'.$localeID.'.'.$entry, 0777);
                } else {
                    file_put_contents($id.'/'.$localeID.'.'.$entry, 1);
                    chmod($id.'/'.$localeID.'.'.$entry, 0777);
                }
            }
        }
    }
    
    return $arr;
}

if (file_exists('paradigm')) {
    $paradigm = file_get_contents('paradigm');
} else {
    $paradigm = 'system';
}
$paradigmData = parseArrayFile($paradigm.'.par');
if (file_exists('year')) {
    $today = file_get_contents('year');
} else {
    $today = $paradigmData['default_year'];
}
$lazones = str_replace('./','',(glob('./*.locale')));
if (file_exists('locale')) {
    $locale = file_get_contents('locale');
} else {
    $locale = basename(array_key_first($lazones), '.locale');
}
$lingua = $locale;
include $lingua.'.diction.php';

$key = $_REQUEST['key'];
$host = ($_REQUEST['host']) ? $_REQUEST['host'] : 'https://github.com';
$pkg = $_REQUEST['pkg'];
$repo = $_REQUEST['repo'];
$branch = ($_REQUEST['branch']) ? $_REQUEST['branch'] : '';
$user = $_REQUEST['user'];

if ($key == 'i' || $key == 's' || $key == 'o') {
    if ($pkg == "from" && $repo != "" && $user != "") {
        if (file_exists($repo)) {
            exec('chmod -R 777 .');
            exec('rm -rf '.$repo);
        }
        
        $request = $host.'/'.$user.'/'.$repo;
        if ($branch != '') {
            exec('git clone -b '.$branch.' '.$request);
        } else {
            exec('git clone '.$request);
        }
        chmod($repo, 0777);
        exec('chmod -R 777 .');
        
        if (file_exists($repo.'/'.$repo.'.data')) {
            $profLoadArr = parseArrayFile($repo.'/'.$repo.'.data');
            foreach ($profLoadArr as $key=>$value) {
                file_put_contents($repo.'/'.$key, $value);
                chmod($repo.'/'.$key, 0777);
            }
        }
        
        if (file_exists($repo.'/'.$lingua.'.'.$repo.'.quotes')) {
            $profQuotesArr = parseArrayFile($repo.'/'.$lingua.'.'.$repo.'.quotes');
            foreach ($profQuotesArr as $key=>$value) {
                if (isset($profLoadArr['name'])) {
                    $gheader = $profLoadArr['name'];
                } else {
                    $gheader = $diction[$lingua]['name'][rand(0, count($diction[$lingua]['name']) - 1)];
                }
                $gletter = $value;
                file_put_contents($repo.'/'.$lingua.'.'.$key.'.art', $gheader.'|[1]|'.$gletter);
                chmod($repo.'/'.$lingua.'.'.$key.'.art', 0777);
            }
        }

        file_put_contents($repo.'/coord', $paradigmData['default_coord']);
        chmod($repo.'/coord', 0777);
        file_put_contents($repo.'/mode', $paradigmData['default_mode']);
        chmod($repo.'/mode', 0777);
        file_put_contents($repo.'/rating', $paradigmData['default_rating']);
        chmod($repo.'/rating', 0777);
        file_put_contents($repo.'/score', $paradigmData['default_score']);
        chmod($repo.'/score', 0777);
        file_put_contents($repo.'/money', $paradigmData['default_money']);
        chmod($repo.'/money', 0777);
        file_put_contents($repo.'/born', $today);
        chmod($repo.'/born', 0777);
        file_put_contents($repo.'/locale', $lingua);
        chmod($repo.'/locale', 0777);
        localeGen($repo);
    }
} elseif ($key == 'r' || $key == 'p' || $key == 'm') {
    if ($pkg != "" && $repo != "" && $user != "") {
        if (file_exists($pkg)) {
            exec('chmod -R 777 .');
            exec('rm -rf '.$pkg);
        }
        header('Location: getdir.php?key=i&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    }
} elseif ($key == 'd' || $key == 'u' || $key == 'x') {
    if ($pkg != "" && $repo == 'from' && $user == 'here') {
        if (file_exists($pkg)) {
            exec('chmod -R 777 .');
            exec('rm -rf '.$pkg);
        }
    }
}

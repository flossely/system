<?php

function getArrFromFile($name): array {
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

function getArrFromJSON($name): array {
    $str = file_get_contents($name);
    $obj = unserialize($str);
    
    return $obj;
}

function getFracFromFile($name) {
    if (file_exists($name)) {
        $str = file_get_contents($name);
        if (is_numeric($str)) {
            $res = $str;
        } else {
            if (strpos($str, '/') !== false) {
                $del = explode('/', $str);
                $res = $del[0] / $del[1];
            } else {
                $res = 1;
            }
        }
    } else {
        $res = 1;
    }
    
    return $res;
}

function getLevelNumber($name) {
    if (file_exists($name)) {
        $source = file_get_contents($name);
        if (is_numeric($source)) {
            if ($source == 2) {
                $result = 2;
            } elseif ($source > 2) {
                $result = 3;
            } else {
                $result = 1;
            }
        } else {
            $result = 1;
        }
    } else {
        $result = 1;
    }
    
    return $result;
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
            } elseif ($entry == 'mtr' || $entry == 'angdig') {
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
            } elseif ($entry == 'mtr' || $entry == 'angdig') {
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

function reader($name, $sub = '') {
    if (file_exists($name)) {
        $buffer = file_get_contents($name);
        if ($sub == 'number') {
            if (is_numeric($buffer)) {
                $content = $buffer;
            } else {
                $content = 0;
            }
        } elseif ($sub == 'bool') {
            $content = boolval($buffer);
        } else {
            if ($buffer != '') {
                $content = $buffer;
            } else {
                $content = $sub;
            }
        }
    } else {
        $content = $sub;
    }
    
    return $content;
}

function getElementsDiff($s, $o) {
    $diff = $s - $o;    
    return $diff;
}

function getElementsRatio($s, $o) {
    $diff = $s / $o;
    return $diff;
}

function calculateAge($t, $b) {
    if ($t >= $b) {
        return $t - $b;
    } else {
        return 0;
    }
}

include 'entdata.php';

function isEntity($id)
{
    $rating = file_exists($id.'/rating');
    $mode = file_exists($id.'/mode');
    $coord = file_exists($id.'/coord');
    $score = file_exists($id.'/score');
    $money = file_exists($id.'/money');
    $born = file_exists($id.'/born');
    $locale = file_exists($id.'/locale');
    
    return ($rating && $mode && $coord && $score && $money && $born && $locale);
}
function isSystem($id)
{
    $info = file_exists($id.'/system.info');
    
    return ($info);
}

function formatYear($p, $i)
{
    $parArr = getArrFromFile($p.'.par');
    
    if ((isset($parArr['historic'])) && ($parArr['historic'] != false)) {
        if ($i >= 0) {
            $append = 'AD';
            $num = $i;
        } else {
            $append = 'BC';
            $num = abs($i);
        }
        
        $result = $num . ' ' . $append;
    } else {
        $result = $i;
    }
    
    return $result;
}

function sorting($arr, $by)
{
    $for = [];
    foreach ($arr as $key=>$value) {
        if (file_exists($value.'/'.$by)) {
            $for[$value] = file_get_contents($value.'/'.$by);
        } else {
            $for[$value] = 0;
        }
    }
    
    return $for;
}
function sorted($arr, $by, $how) {
    $index = sorting($arr, $by);
    $order = $index;
    
    if ($how == 'ASC') {
        asort($order, SORT_NUMERIC);
    } else {
        arsort($order, SORT_NUMERIC);
    }
    
    $result = [];
    foreach ($order as $key=>$value) {
        $result[] = $key;
    }
    
    return $result;
}
function leader($arr, $prop, $how) {
    if ($how == 'ASC') {
        return array_search(min(sorting($arr, $prop)), sorting($arr, $prop));
    } else {
        return array_search(max(sorting($arr, $prop)), sorting($arr, $prop));
    }
}
function horizontal($a) {
    return (($a == 1) || ($a == 3));
}

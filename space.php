<?php

function getArrayFromFile($name): array {
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

function getFractionFromFile($name) {
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

function coordArr($str) {
    $per = explode(';', $str);
    
    $x = (is_numeric($per[0])) ? $per[0] : 0;
    $y = (is_numeric($per[1])) ? $per[1] : 0;
    $z = (is_numeric($per[2])) ? $per[2] : 0;
    
    $arr = [
        'x' => $x,
        'y' => $y,
        'z' => $z
    ];
    
    return $arr;
}

function rand_float($start = 0, $end = 1, $mul = 1000000) {
    if ($start > $end) {
        $result = false;
    } else {
        $result = mt_rand($start * $mul, $end * $mul) / $mul;
    }
    
    return $result;
}

function age($b, $t) {
    if ($t >= $b) {
        $result = $t - $b;
    } else {
        $result = 0;
    }

    return $result;
}

function self($s, $o) {
    return ($s == $o);
}

function alive($r) {
    return ($r >= 0);
}

function valuable($r) {
    return ($r > 0);
}

function getSpeed($r) {
    if (valuable($r)) {
        return rand_float(0, $r, 1000);
    } else {
        return 1;
    }
}
function getReach($r) {
    if (valuable($r)) {
        return $r;
    } else {
        return 1;
    }
}

function turnFormat($p, $i)
{
    $parArr = getArrayFromFile($p.'.par');
    
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

function dist($ix, $iy, $iz, $jx, $jy, $jz) {
    if ($ix > $jx) {
        $dix = $ix - $jx;
    } elseif ($ix < $jx) {
        $dix = $jx - $ix;
    } elseif ($ix == $jx) {
        $dix = 0;
    }
    if ($iy > $jy) {
        $diy = $iy - $jy;
    } elseif ($iy < $jy) {
        $diy = $jy - $iy;
    } elseif ($iy == $jy) {
        $diy = 0;
    }
    if ($iz > $jz) {
        $diz = $iz - $jz;
    } elseif ($iz < $jz) {
        $diz = $jz - $iz;
    } elseif ($iz == $jz) {
        $diz = 0;
    }
    
    return sqrt($dix ** 2 + $diy ** 2 + $diz ** 2);
}

function reach($ix, $iy, $iz, $jx, $jy, $jz, $r) {
    if ($ix > $jx) {
        $dix = $ix - $jx;
    } elseif ($ix < $jx) {
        $dix = $jx - $ix;
    } elseif ($ix == $jx) {
        $dix = 0;
    }
    if ($iy > $jy) {
        $diy = $iy - $jy;
    } elseif ($iy < $jy) {
        $diy = $jy - $iy;
    } elseif ($iy == $jy) {
        $diy = 0;
    }
    if ($iz > $jz) {
        $diz = $iz - $jz;
    } elseif ($iz < $jz) {
        $diz = $jz - $iz;
    } elseif ($iz == $jz) {
        $diz = 0;
    }
    
    return (($dix <= $r) && ($diy <= $r) && ($diz <= $r));
}

function letterMode($m) {
    if ($m > 0) {
        return 'r';
    } elseif ($m < 0) {
        return 'l';
    } else {
        return 'c';
    } 
}

function relate($sm, $om) {
    return letterMode($sm).letterMode($om);
}

function compareModes($s, $o) {
    $r = ($s - $o) + 3;

    return $r;
}

function diffCalc($s, $o) {
    $diff = $s - $o;
    return $diff;
}

function ratioCalc($s, $o) {
    $diff = $s / $o;
    return $diff;
}

function getLevelNum($name) {
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

function useNotation($id) {
    if ($id == '.') {
        $note = '#'.basename(__DIR__);
    } else {
        $note = '@'.$id;
    }
    return $note;
}

function useFullName($id) {
    if (file_exists($id.'/name')) {
        $filename = file_get_contents($id.'/name');
        if ($filename != '') {
            return $filename;
        } else {
            return useNotation($id);
        }
    } else {
        return useNotation($id);
    }
}

function shopFor($dir, $cat) {
    $list = str_replace($dir.'/','',(glob($dir.'/*.'.$cat.'.obj')));
    $count = count($list);
    if (!empty($list)) {
        $obj = $list[rand(0, $count - 1)];
        $hold = getArrayFromFile($dir.'/'.$obj);
        $hold['object_file'] = $obj;
        $hold['object_class'] = $cat;
        $hold['object_id'] = basename($obj, '.'.$cat.'.obj');
    } else {
        $hold = null;
    }
    
    return $hold;
}

function classEmpty($dir, $cat) {
    $list = str_replace($dir.'/','',(glob($dir.'/*.'.$cat.'.obj')));
    return empty($list);
}

function initMine($agent) {
    $agentRating = file_get_contents($agent.'/rating');
    $agentScore = file_get_contents($agent.'/score');
    $agentLocale = file_get_contents($agent.'/locale');
    $agentSign = file_get_contents($agent.'/'.$agentLocale.'.cur');
    $agentMoney = file_get_contents($agent.'/money');
    $agentMoney += getReach($agentRating) * getReach($agentScore);
    $resultArr = ['money' => $agentMoney, 'sign' => $agentSign];
    return $resultArr;
}

function getZonesData($zones) {
    $econValues = [];
    foreach ($zoneList as $str) {
        if (file_exists($str.'.curval')) {
            if (is_numeric(file_get_contents($str.'.curval'))) {
                $econValues[$str] = file_get_contents($str.'.curval');
            } else {
                $econValues[$str] = 1;
            }
        } else {
            $econValues[$str] = 1;
        }
    }
    $econSides = [];
    foreach ($zoneList as $str) {
        if (file_exists($str.'.curside')) {
            if (is_numeric(file_get_contents($str.'.curside'))) {
                $econSides[$str] = file_get_contents($str.'.curside');
            } else {
                $econSides[$str] = 1;
            }
        } else {
            $econSides[$str] = 1;
        }
    }
    $econSigns = [];
    foreach ($zoneList as $str) {
        if (file_exists($str.'.cur')) {
            if ((file_get_contents($str.'.cur')) != '') {
                $econSigns[$str] = file_get_contents($str.'.cur');
            } else {
                $econSigns[$str] = '$';
            }
        } else {
            $econSigns[$str] = '$';
        }
    }
    
    $econArr = [];
    $econArr['values'] = $econValues;
    $econArr['sides'] = $econSides;
    $econArr['signs'] = $econSigns;
    
    return $econArr;
}

function movement($yearStr, $agentStr, $x, $y, $z, $level, $speed) {
    $howmove = rand(0, $level);
    
    if ($howmove == 0) {
        $x += $speed;
    } elseif ($howmove == 1) {
        $x -= $speed;
    } elseif ($howmove == 2) {
        $y += $speed;
    } elseif ($howmove == 3) {
        $y -= $speed;
    } elseif ($howmove == 4) {
        $z += $speed;
    } elseif ($howmove == 5) {
        $z -= $speed;
    }
    
    $coord = ['x' => $x, 'y' => $y, 'z' => $z];

    echo $yearStr . ' : ' . $agentStr . ' {' . $x . ';' . $y . ';' . $z . '}<br>';
    
    return $coord;
}

function synchrone($yearStr, $i, $ix, $iy, $iz, $j, $jx, $jy, $jz, $level, $speed) {
    $howmove = rand(0, $level);
    
    if ($howmove == 0) {
        $ix += $speed;
    } elseif ($howmove == 1) {
        $ix -= $speed;
    } elseif ($howmove == 2) {
        $iy += $speed;
    } elseif ($howmove == 3) {
        $iy -= $speed;
    } elseif ($howmove == 4) {
        $iz += $speed;
    } elseif ($howmove == 5) {
        $iz -= $speed;
    }
    
    $coord =
    [
        'i' =>
        [
            'x' => $ix,
            'y' => $iy,
            'z' => $iz
        ],
        'j' =>
        [
            'x' => $jx,
            'y' => $jy,
            'z' => $jz
        ]
    ];

    echo $yearStr.' : '.$i.' {'.$ix.';'.$iy.';'.$iz.'} '.$j.' {'.$jx.';'.$jy.';'.$jz.'} <br>';
    
    return $coord;
}

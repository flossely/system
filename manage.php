<?php

if (file_exists('paradigm')) {
    $callforParadigm = file_get_contents('paradigm');
} else {
    $callforParadigm = 'system';
}
$callforParadigmFile = file_get_contents($callforParadigm.'.par');
$callforParadigmArr = explode('|[1]|', $callforParadigmFile);
$callforParadigmData = [];
foreach ($callforParadigmArr as $callforParadigmVal) {
    $callforParadigmExp = explode('|[>]|', $callforParadigmVal);
    $callforParadigmElemProp = $callforParadigmExp[0];
    $callforParadigmElemVal = $callforParadigmExp[1];
    $callforParadigmData[$callforParadigmElemProp] = $callforParadigmElemVal;
}

if (file_exists('year')) {
    $callforTodayYear = file_get_contents('year');
} else {
    $callforTodayYear = $callforParadigmData['default_year'];
}

function recurseCopy(
    string $sourceDirectory,
    string $destinationDirectory,
    string $childFolder = ''
): void {
    $directory = opendir($sourceDirectory);

    if (is_dir($destinationDirectory) === false) {
        mkdir($destinationDirectory);
        chmod($destinationDirectory, 0777);
    }

    if ($childFolder !== '') {
        if (is_dir("$destinationDirectory/$childFolder") === false) {
            mkdir("$destinationDirectory/$childFolder");
            chmod("$destinationDirectory/$childFolder", 0777);
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true) {
                recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            } else {
                copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
                chmod("$destinationDirectory/$childFolder/$file", 0777);
            }
        }

        closedir($directory);

        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$sourceDirectory/$file") === true) {
            recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$file");
            chmod("$destinationDirectory/$file", 0777);
        }
        else {
            copy("$sourceDirectory/$file", "$destinationDirectory/$file");
            chmod("$destinationDirectory/$file", 0777);
        }
    }

    closedir($directory);
}

function getForce($sf, $sm, $om, $fk) {
    if ($sm > $om) {
        $k = $fk + ($sm - $om);
        return $sf * $k;
    } elseif ($sm < $om) {
        $k = $fk + ($om - $sm);
        return $sf / $k;
    } else {
        return $sf;
    }
}

$dir = '.';
$mode = $_POST['mode'];
$id = $_POST['id'];
$data = $_POST['data'];
$sequence = explode(';', $data);
$count = count($sequence);
$last = $count - 1;
if ($mode == 'init') {
    foreach ($sequence as $key=>$value) {
        if (strpos($value, ':') !== false) {
            $valSep = explode(':', $value);
            $valName = $valSep[0];
            $valType = $valSep[1];
            if (!file_exists($valName)) {
                mkdir($valName);
                chmod($valName, 0777);
                if ($valType == 'profile') {
                    file_put_contents($valName.'/rating', 0);
                    chmod($valName.'/rating', 0777);
                    file_put_contents($valName.'/mode', 0);
                    chmod($valName.'/mode', 0777);
                } elseif ($valType == 'system') {
                    if (file_exists('get.php')) {
                        copy('get.php', $valName.'/get.php');
                        chmod($valName.'/get.php', 0777);
                    }
                } elseif ($valType == 'both') {
                    file_put_contents($valName.'/rating', 0);
                    chmod($valName.'/rating', 0777);
                    file_put_contents($valName.'/mode', 0);
                    chmod($valName.'/mode', 0777);
                    if (file_exists('get.php')) {
                        copy('get.php', $valName.'/get.php');
                        chmod($valName.'/get.php', 0777);
                    }
                }
            }
        } else {
            if (!file_exists($value)) {
                mkdir($value);
                chmod($value, 0777);
                file_put_contents($value.'/rating', 0);
                chmod($value.'/rating', 0777);
                file_put_contents($value.'/mode', 0);
                chmod($value.'/mode', 0777);
            }
        }
    }
} elseif ($mode == 'kill') {
    foreach ($sequence as $key=>$value) {
        if ($value != '' && file_exists($value)) {
            chmod($value, 0777);
            exec('rm -rf '.$value);
        }
    }
} elseif ($mode == 'modify') {
    foreach ($sequence as $key=>$value) {
        if (strpos($value, ':') !== false) {
            $valSep = explode(':', $value);
            $valName = $valSep[0];
            $valDef = $valSep[1];
            if (file_exists($valName)) {
                if (is_numeric($valDef)) {
                    file_put_contents($valName.'/rating', $valDef);
                    chmod($valName.'/rating', 0777);
                } elseif ($valDef == 'left') {
                    file_put_contents($valName.'/mode', -1);
                    chmod($valName.'/mode', 0777);
                } elseif ($valDef == 'center') {
                    file_put_contents($valName.'/mode', 0);
                    chmod($valName.'/mode', 0777);
                } elseif ($valDef == 'right') {
                    file_put_contents($valName.'/mode', 1);
                    chmod($valName.'/mode', 0777);
                } elseif ($valDef == 'system') {
                    copy('get.php', $valName.'/get.php');
                    chmod($valName.'/get.php', 0777);
                } else {
                    file_put_contents($valName.'/rating', 0);
                    chmod($valName.'/rating', 0777);
                    file_put_contents($valName.'/mode', 0);
                    chmod($valName.'/mode', 0777);
                }
            }
        } else {
            if (file_exists($value)) {
                file_put_contents($value.'/rating', 0);
                chmod($value.'/rating', 0777);
                file_put_contents($value.'/mode', 0);
                chmod($value.'/mode', 0777);
            }
        }
    }
} elseif ($mode == 'join') {
    if (file_exists($id)) {
        foreach ($sequence as $key=>$value) {
            $entID = $value;
            if (file_exists($entID)) {
                if (is_dir($entID)) {
                    chmod($entID, 0777);
                    recurseCopy($entID, $id.'/'.$entID);
                    chmod($id.'/'.$entID, 0777);
                    exec('rm -rf '.$entID);
                } else {
                    chmod($entID, 0777);
                    rename($entID, $id.'/'.$entID);
                    chmod($id.'/'.$entID, 0777);
                }
            }
        }
    }
} elseif ($mode == 'leave') {
    if (file_exists($id)) {
        foreach ($sequence as $key=>$value) {
            $entID = $value;
            if (file_exists($id.'/'.$entID)) {
                if (is_dir($id.'/'.$entID)) {
                    chmod($id.'/'.$entID, 0777);
                    recurseCopy($id.'/'.$entID, $dir.'/'.$entID);
                    chmod($dir.'/'.$entID, 0777);
                    exec('rm -rf '.$id.'/'.$entID);
                } else {
                    chmod($id.'/'.$entID, 0777);
                    rename($id.'/'.$entID, $dir.'/'.$entID);
                    chmod($dir.'/'.$entID, 0777);
                }
            }
        }
    }
} elseif ($mode == 'merge') {
    if (!file_exists($id)) {
        mkdir($id);
        chmod($id, 0777);
        $finRating = 0;
        $modeArr = [];
        $concat = '';
        foreach ($sequence as $key=>$value) {
            if (strpos($value, ':') !== false) {
                $entPart = explode(':', $value);
                $entID = $entPart[0];
                $entFiles = $entPart[1];
                $entFileList = explode(',', $entFiles);
                if (in_array('mode', $entFileList) && in_array('rating', $entFileList)) {
                    unset($entFileList[array_search('mode', $entFileList)]);
                    unset($entFileList[array_search('rating', $entFileList)]);
                }
                foreach ($entFileList as $iter=>$file) {
                    $fullFile = $concat.$file;
                    if (is_dir($entID.'/'.$file)) {
                        chmod($entID.'/'.$file, 0777);
                        recurseCopy($entID.'/'.$file, $id.'/'.$fullFile);
                        chmod($id.'/'.$fullFile, 0777);
                    } else {
                        chmod($entID.'/'.$file, 0777);
                        rename($entID.'/'.$file, $id.'/'.$fullFile);
                        chmod($id.'/'.$fullFile, 0777);
                    }
                }
            } else {
                $entID = $value;
                $entFiles = str_replace($dir.'/'.$entID.'/','',(glob($dir.'/'.$entID.'/*')));
                if (in_array('mode', $entFiles) && in_array('rating', $entFiles)) {
                    unset($entFiles[array_search('mode', $entFiles)]);
                    unset($entFiles[array_search('rating', $entFiles)]);
                }
                foreach ($entFiles as $iter=>$file) {
                    $fullFile = $concat.$file;
                    if (is_dir($entID.'/'.$file)) {
                        chmod($entID.'/'.$file, 0777);
                        recurseCopy($entID.'/'.$file, $id.'/'.$fullFile);
                        chmod($id.'/'.$fullFile, 0777);
                    } else {
                        chmod($entID.'/'.$file, 0777);
                        rename($entID.'/'.$file, $id.'/'.$fullFile);
                        chmod($id.'/'.$fullFile, 0777);
                    }
                }
            }
            $entRating = file_get_contents($entID.'/rating');
            $entMode = file_get_contents($entID.'/mode');
            $addRating = ($entRating > 0) ? $entRating : 1;
            $finRating += $addRating;
            $modeArr[] = $entMode;
            $concat .= '#';
            chmod($entID, 0777);
            exec('rm -rf '.$entID);
        }
        $slice = array_slice($modeArr, 0, $count);
        $result = round((array_sum($slice) / sizeof($slice)), 0);
        if ($result > 0) {
            $finMode = 1;
        } elseif ($result < 0) {
            $finMode = -1;
        } else {
            $finMode = 0;
        }
        file_put_contents($id.'/rating', $finRating);
        chmod($id.'/rating', 0777);
        file_put_contents($id.'/mode', $finMode);
        chmod($id.'/mode', 0777);
    }
} elseif ($mode == 'divide') {
    $rating = file_get_contents($id.'/rating');
    $itmode = file_get_contents($id.'/mode');
    $concat = '';
    $revConcat = '';
    for ($i = 0; $i < $last; $i++) {
        $revConcat .= '#';
    }
    foreach ($sequence as $key=>$value) {
        if (strpos($value, ':') !== false) {
            $entPart = explode(':', $value);
            $entID = $entPart[0];
            $entRating = round(($rating / $count), 0);
            $entMode = $itmode;
            $entFiles = $entPart[1];
            $entFileList = explode(',', $entFiles);
            if (in_array('mode', $entFileList) && in_array('rating', $entFileList)) {
                unset($entFileList[array_search('mode', $entFileList)]);
                unset($entFileList[array_search('rating', $entFileList)]);
            }
            if (!file_exists($entID)) {
                mkdir($entID);
                chmod($entID, 0777);
                foreach ($entFileList as $iter=>$file) {
                    if (is_dir($id.'/'.$file)) {
                        chmod($id.'/'.$file, 0777);
                        recurseCopy($id.'/'.$file, $entID.'/'.$file);
                        chmod($entID.'/'.$file, 0777);
                    } else {
                        chmod($id.'/'.$file, 0777);
                        copy($id.'/'.$file, $entID.'/'.$file);
                        chmod($entID.'/'.$file, 0777);
                    }
                }
                file_put_contents($entID.'/rating', $entRating);
                chmod($entID.'/rating', 0777);
                file_put_contents($entID.'/mode', $entMode);
                chmod($entID.'/mode', 0777);
            }
        } else {
            $entID = $value;
            $entRating = round(($rating / $count), 0);
            $entMode = $itmode;
            if ($concat == '') {
                $entFiles = str_replace($dir.'/'.$id.'/','',(glob($dir.'/'.$id.'/*')));
            
            } else {
                $entFiles = str_replace($dir.'/'.$id.'/'.$revConcat,'',(glob($dir.'/'.$id.'/'.$concat.'*')));
            }
            if (in_array('mode', $entFiles) && in_array('rating', $entFiles)) {
                unset($entFiles[array_search('mode', $entFiles)]);
                unset($entFiles[array_search('rating', $entFiles)]);
            }
            if (!file_exists($entID)) {
                mkdir($entID);
                chmod($entID, 0777);
                foreach ($entFiles as $iter=>$file) {
                    if (strpos($file, '#') !== false) {
                        $fullFile = str_replace('#', '', $file);
                    } else {
                        $fullFile = $file;
                    }
                    if (is_dir($id.'/'.$file)) {
                        chmod($id.'/'.$file, 0777);
                        recurseCopy($id.'/'.$file, $entID.'/'.$fullFile);
                        chmod($entID.'/'.$fullFile, 0777);
                    } else {
                        chmod($id.'/'.$file, 0777);
                        copy($id.'/'.$file, $entID.'/'.$fullFile);
                        chmod($entID.'/'.$fullFile, 0777);
                    }
                }
                file_put_contents($entID.'/rating', $entRating);
                chmod($entID.'/rating', 0777);
                file_put_contents($entID.'/mode', $entMode);
                chmod($entID.'/mode', 0777);
            }
        }
        $concat .= '#';
        $revConcat = ltrim($revConcat, '#');
    }
    chmod($id, 0777);
    exec('rm -rf '.$id);
} elseif ($mode == 'reset') {
    $profiles = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
    foreach ($profiles as $key=>$value) {
        if (!file_exists($value.'/rating') && !file_exists($value.'/mode')) {
            unset($profiles[array_search($value, $profiles)]);
        }
    }
    foreach ($profiles as $key=>$value) {
        file_put_contents($value.'/born', $callforTodayYear);
        chmod($value.'/born', 0777);
        if (isset($callforParadigmData['starting_rating'])) {
            file_put_contents($value.'/rating', $callforParadigmData['starting_rating']);
            chmod($value.'/rating', 0777);
        }
        if (isset($callforParadigmData['starting_mode'])) {
            file_put_contents($value.'/mode', $callforParadigmData['starting_mode']);
            chmod($value.'/mode', 0777);
        }
        if (isset($callforParadigmData['starting_coord'])) {
            file_put_contents($value.'/coord', $callforParadigmData['starting_coord']);
            chmod($value.'/coord', 0777);
        }
        if (isset($callforParadigmData['starting_score'])) {
            file_put_contents($value.'/score', $callforParadigmData['starting_score']);
            chmod($value.'/score', 0777);
        }
        if (isset($callforParadigmData['starting_money'])) {
            file_put_contents($value.'/money', $callforParadigmData['starting_money']);
            chmod($value.'/money', 0777);
        }
    }
} elseif ($mode == 'hit') {
    $subRating = file_get_contents($id.'/rating');
    $subMode = file_get_contents($id.'/mode');
    foreach ($sequence as $key=>$value) {
        if (strpos($value, ':') !== false) {
            $valSep = explode(':', $value);
            $valName = $valSep[0];
            $valDef = $valSep[1];
            $objRating = file_get_contents($valName.'/rating');
            $objMode = file_get_contents($valName.'/mode');
            if (is_numeric($valDef)) {
                $subForce = $valDef;
                $subAddForce = getForce($subForce, $subMode, $objMode, 2);
                $subRatingEffect = round($subAddForce, 0);
                $objRating = $objRating - $subRatingEffect;
                $subRating = $subRating + $subRatingEffect;
            } else {
                $subForce = 2;
                $subAddForce = getForce($subForce, $subMode, $objMode, 2);
                $subRatingEffect = round($subAddForce, 0);
                $objRating = $objRating - $subRatingEffect;
                $subRating = $subRating + $subRatingEffect;
            }
            file_put_contents($valName.'/rating', $objRating);
            chmod($valName.'/rating', 0777);
            file_put_contents($valName.'/mode', $objMode);
            chmod($valName.'/mode', 0777);
        } else {
            $objRating = file_get_contents($value.'/rating');
            $objMode = file_get_contents($value.'/mode');
            $subForce = 2;
            $subAddForce = getForce($subForce, $subMode, $objMode, 2);
            $subRatingEffect = round($subAddForce, 0);
            $objRating = $objRating - $subRatingEffect;
            $subRating = $subRating + $subRatingEffect;
            file_put_contents($value.'/rating', $objRating);
            chmod($value.'/rating', 0777);
            file_put_contents($value.'/mode', $objMode);
            chmod($value.'/mode', 0777);
        }
        file_put_contents($id.'/rating', $subRating);
        chmod($id.'/rating', 0777);
        file_put_contents($id.'/mode', $subMode);
        chmod($id.'/mode', 0777);
    }
} elseif ($mode == 'heal') {
    $subRating = file_get_contents($id.'/rating');
    $subMode = file_get_contents($id.'/mode');
    foreach ($sequence as $key=>$value) {
        if (strpos($value, ':') !== false) {
            $valSep = explode(':', $value);
            $valName = $valSep[0];
            $valDef = $valSep[1];
            $objRating = file_get_contents($valName.'/rating');
            $objMode = file_get_contents($valName.'/mode');
            if (is_numeric($valDef)) {
                $subForce = $valDef;
                $subAddForce = getForce($subForce, $subMode, $objMode, 2);
                $subRatingEffect = round($subAddForce, 0);
                $objRating = $objRating + $subRatingEffect;
                $subRating = $subRating - $subRatingEffect;
            } else {
                $subForce = 2;
                $subAddForce = getForce($subForce, $subMode, $objMode, 2);
                $subRatingEffect = round($subAddForce, 0);
                $objRating = $objRating + $subRatingEffect;
                $subRating = $subRating - $subRatingEffect;
            }
            file_put_contents($valName.'/rating', $objRating);
            chmod($valName.'/rating', 0777);
            file_put_contents($valName.'/mode', $objMode);
            chmod($valName.'/mode', 0777);
        } else {
            $objRating = file_get_contents($value.'/rating');
            $objMode = file_get_contents($value.'/mode');
            $subForce = 2;
            $subAddForce = getForce($subForce, $subMode, $objMode, 2);
            $subRatingEffect = round($subAddForce, 0);
            $objRating = $objRating + $subRatingEffect;
            $subRating = $subRating - $subRatingEffect;
            file_put_contents($value.'/rating', $objRating);
            chmod($value.'/rating', 0777);
            file_put_contents($value.'/mode', $objMode);
            chmod($value.'/mode', 0777);
        }
        file_put_contents($id.'/rating', $subRating);
        chmod($id.'/rating', 0777);
        file_put_contents($id.'/mode', $subMode);
        chmod($id.'/mode', 0777);
    }
}

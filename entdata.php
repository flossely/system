<?php

function gatherEntityData($id) {
    $arr = [];
    $omit = [];
    if (file_exists($id)) {
        $arr['id'] = $id;
        if (file_exists($id.'/name')) {
            $arr['name'] = file_get_contents($id.'/name');
        } else {
            $arr['name'] = $arr['id'];
        }
        if (file_exists($id.'/type')) {
            $arr['type'] = file_get_contents($id.'/type');
        } else {
            $arr['type'] = 'usr';
        }
        if (file_exists($id.'/rating')) {
            $arr['rating'] = file_get_contents($id.'/rating');
        } else {
            $arr['rating'] = 0;
        }
        if (file_exists($id.'/mode')) {
            $arr['mode'] = file_get_contents($id.'/mode');
        } else {
            $arr['mode'] = 0;
        }
        if ($arr['mode'] > 0) {
            $arr['sign'] = '+@';
        } elseif ($arr['mode'] < 0) {
            $arr['sign'] = '-@';
        } else {
            $arr['sign'] = '@';
        }
        if (file_exists($id.'/score')) {
            $arr['score'] = file_get_contents($id.'/score');
        } else {
            $arr['score'] = 0;
        }
        if (file_exists($id.'/money')) {
            $arr['money'] = file_get_contents($id.'/money');
        } else {
            $arr['money'] = 0;
        }
        if (file_exists($id.'/year')) {
            $arr['year'] = file_get_contents($id.'/year');
        } else {
            $arr['year'] = 0;
        }
        if (file_exists($id.'/born')) {
            if ((file_get_contents($id.'/born')) != '') {
                $arr['born'] = file_get_contents($id.'/born');
            } else {
                $arr['born'] = 0;
            }
        } else {
            $arr['born'] = 0;
        }
        if (file_exists($id.'/coord')) {
            $arr['coord'] = file_get_contents($id.'/coord');
        } else {
            $arr['coord'] = '0;0;0';
        }
        $omit['zones'] = str_replace($id.'/','',(glob($id.'/*.locale')));
        if (!empty($omit['zones'])) {
            $arr['zones'] = str_replace('.locale','',implode(',', $omit['zones']));
        } else {
            $arr['zones'] = 'eu,us';
        }
        if (file_exists($id.'/locale')) {
            $arr['locale'] = file_get_contents($id.'/locale');
        } else {
            $arr['locale'] = basename(array_key_first($arr['zones']), '.locale');
        }
        if (file_exists($arr['locale'].'.curval')) {
            $arr['curval'] = file_get_contents($arr['locale'].'.curval');
        } else {
            $arr['curval'] = 1;
        }
        if (file_exists($arr['locale'].'.cur')) {
            $arr['cur'] = file_get_contents($arr['locale'].'.cur');
        } else {
            $arr['cur'] = '$';
        }
        if (file_exists($arr['locale'].'.mtr')) {
            $arr['mtr'] = file_get_contents($arr['locale'].'.mtr');
        } else {
            $arr['mtr'] = 0;
        }
        if (file_exists($arr['locale'].'.long')) {
            $arr['long'] = file_get_contents($arr['locale'].'.long');
        } else {
            $arr['long'] = 1;
        }
        if (file_exists($arr['locale'].'.mass')) {
            $arr['mass'] = file_get_contents($arr['locale'].'.mass');
        } else {
            $arr['mass'] = 1;
        }
        if (file_exists($id.'/bshp')) {
            $arr['bshp'] = file_get_contents($id.'/bshp');
        } else {
            $arr['bshp'] = 0;
        }
        if (file_exists($id.'/fshp')) {
            $arr['fshp'] = file_get_contents($id.'/fshp');
        } else {
            $arr['fshp'] = 0;
        }
        if (file_exists($id.'/birth')) {
            $arr['birth'] = file_get_contents($id.'/birth');
        } else {
            $arr['birth'] = 0;
        }
        if (file_exists($id.'/ratio')) {
            $arr['ratio'] = getFracFromFile($id.'/ratio');
        } else {
            $arr['ratio'] = 1;
        }
        if (file_exists($id.'/size')) {
            $arr['size'] = file_get_contents($id.'/size');
        } else {
            $arr['size'] = 0;
        }
        $omit['nude'] = str_replace($id.'/','',(glob($id.'/n*.*.png', GLOB_BRACE)));
        if (!empty($omit['nude'])) {
            $arr['nude'] = count($omit['nude']);
            $arr['nsfw'] = 'true';
        } else {
            $arr['nude'] = 0;
            $arr['nsfw'] = 'false';
        }
    } else {
        $arr['id'] = '';
        $arr['name'] = '';
        $arr['type'] = 'usr';
        $arr['rating'] = 0;
        $arr['mode'] = 0;
        $arr['sign'] = '@';
        $arr['score'] = 0;
        $arr['money'] = 0;
        $arr['year'] = 0;
        $arr['born'] = 0;
        $arr['coord'] = '0;0;0';
        $arr['zones'] = 'eu,us';
        $arr['locale'] = 'us';
        $arr['curval'] = 1;
        $arr['cur'] = '$';
        $arr['mtr'] = 0;
        $arr['long'] = 1;
        $arr['mass'] = 1;
        $arr['bshp'] = 0;
        $arr['fshp'] = 0;
        $arr['birth'] = 0;
        $arr['ratio'] = 1;
        $arr['size'] = 0;
        $arr['nude'] = 0;
        $arr['nfsw'] = 'false';
    }
    
    return $arr;
}


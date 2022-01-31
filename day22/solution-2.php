<?php
$file = file('input.txt');
$zones = [];
foreach ($file as $line) {
    [$type, $dimensions] = explode(' ', trim($line));
    [$x, $y, $z] = explode(',', $dimensions);
    $zones[] = [
        'light' => $type == 'on' ? 1 : -1,
        'x' => explode('..', str_replace('x=', '', $x)),
        'y' => explode('..', str_replace('y=', '', $y)),
        'z' => explode('..', str_replace('z=', '', $z)),
    ];
}
$xRange = [0, 0];
$yRange = [0, 0];
$zRange = [0, 0];
foreach ($zones as $zone) {
    if ($zone['light'] > 0) {
        $xRange[0] = min($zone['x'][0], $xRange[0]);
        $yRange[0] = min($zone['y'][0], $yRange[0]);
        $zRange[0] = min($zone['z'][0], $zRange[0]);
        $xRange[1] = max($zone['x'][1], $xRange[1]);
        $yRange[1] = max($zone['y'][1], $yRange[1]);
        $zRange[1] = max($zone['z'][1], $zRange[1]);
    }
}

$answer = 0;

for ($x = $xRange[0]; $x <= $xRange[1]; $x++) {
    for ($y = $yRange[0]; $y <= $yRange[1]; $y++) {
        for ($z = $zRange[0]; $z <= $zRange[1]; $z++) {
            $light = 0;
            foreach ($zones as $zone) {
                if ($x >= $zone['x'][0] && $x <= $zone['x'][1]) {
                    if ($y >= $zone['y'][0] && $y <= $zone['y'][1]) {
                        if ($z >= $zone['z'][0] && $z <= $zone['z'][1]) {
                            $light = $zone['light'];
                        }
                    }
                }
            }

            if ($light > 0) {
                $answer++;
            }
        }
    }
}

echo $answer;
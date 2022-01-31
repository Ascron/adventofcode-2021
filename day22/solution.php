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

$answer = 0;

for ($x = -50; $x <= 50; $x++) {
    for ($y = -50; $y <= 50; $y++) {
        for ($z = -50; $z <= 50; $z++) {
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
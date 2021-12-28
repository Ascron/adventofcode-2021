<?php
$heightmap = file('input.txt');
foreach ($heightmap as &$row) {
    $row = str_split(trim($row));
}

function consume(&$heightmap, $y, $x) {
    $val = $heightmap[$y][$x];
    unset($heightmap[$y][$x]);
    if ($val == 9) {
        return 0;
    }

//    echo $y . ' ' . $x . PHP_EOL;

    $result = 1;

    if (isset($heightmap[$y + 1][$x])) {
        $result += consume($heightmap, $y + 1, $x);
    }

    if (isset($heightmap[$y - 1][$x])) {
        $result += consume($heightmap, $y - 1, $x);
    }

    if (isset($heightmap[$y][$x + 1])) {
        $result += consume($heightmap, $y, $x + 1);
    }

    if (isset($heightmap[$y][$x - 1])) {
        $result += consume($heightmap, $y, $x - 1);
    }

    return $result;
}

$basins = [];
$height = count($heightmap);
$width = count($heightmap[0]);
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if (isset($heightmap[$y][$x]) && $heightmap[$y][$x] != 9) {
            $basins[] = consume($heightmap, $y, $x);
        }
    }
}

rsort($basins);
$result = 1;
print_r($basins);
for ($i = 0; $i < 3; $i++) {
    $result *= $basins[$i];
}
echo $result;
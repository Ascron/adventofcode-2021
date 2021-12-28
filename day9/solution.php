<?php
$heightmap = file('input.txt');
foreach ($heightmap as &$row) {
    $row = str_split(trim($row));
}

$radius = function ($y, $x) {
    return [
        [$y, $x + 1],
        [$y, $x - 1],
        [$y - 1, $x],
        [$y + 1, $x]
    ];
};
$result = 0;
for ($y = 0, $height = count($heightmap); $y < $height; $y++) {
    for ($x = 0, $width = count($heightmap[$y]); $x < $width; $x++) {
        foreach ($radius($y, $x) as $point) {
            if (
                isset($heightmap[$point[0]][$point[1]])
                && $heightmap[$y][$x] >= $heightmap[$point[0]][$point[1]]
            ) {
                continue 2;
            }
        }

        $result += ($heightmap[$y][$x] + 1);
    }
}

echo $result;
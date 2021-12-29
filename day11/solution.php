<?php
$file = file('input.txt');

$grid = array_map(function ($item) {
    return str_split(trim($item));
}, $file);

$inc = function($grid) {
    return array_map(function ($item) {
        return array_map(function ($item) {
            return $item + 1;
        }, $item);
    }, $grid);
};

//print_r($grid);

function flash(&$grid, $y, $x) {
    if ($grid[$y][$x] > 9) {
        $result = 1;
        $grid[$y][$x] = 0;

        $points = [
            [$y + 1, $x],
            [$y - 1, $x],
            [$y + 1, $x + 1],
            [$y - 1, $x + 1],
            [$y + 1, $x - 1],
            [$y - 1, $x - 1],
            [$y, $x + 1],
            [$y, $x - 1],
        ];

        foreach ($points as $point) {
            if (isset($grid[$point[0]][$point[1]]) && $grid[$point[0]][$point[1]]) {
                $grid[$point[0]][$point[1]]++;
                $result += flash($grid, $point[0], $point[1]);
            }
        }

        return $result;
    }

    return 0;
};

$result = 0;

for ($i = 0; $i < 100; $i++) {
    $grid = $inc($grid);
    for ($y = 0, $width = count($grid); $y < $width; $y++) {
        for ($x = 0, $height = count($grid[$y]); $x < $height; $x++) {
            $result += flash($grid, $y, $x);
        }
    }
}

echo $result;
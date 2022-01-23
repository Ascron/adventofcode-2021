<?php
$map = file('input.txt');
foreach ($map as &$row) {
    $row = str_split(trim($row));
}

$difficultyMap = [
    0 => [
        0 => 0,
    ]
];

function move ($map, &$difficultyMap, $fromX, $fromY, $x, $y) {
    if (!isset($difficultyMap[$y][$x])) {
        $difficultyMap[$y][$x] = $difficultyMap[$fromY][$fromX] + $map[$y][$x];
    } else {
        $difficultyMap[$y][$x] = min($difficultyMap[$y][$x], $difficultyMap[$fromY][$fromX] + $map[$y][$x]);
    }

    if (isset($map[$y][$x + 1]) && (!isset($difficultyMap[$y][$x + 1]) || $difficultyMap[$y][$x + 1] > $difficultyMap[$y][$x] + $map[$y][$x + 1])) {
        move($map, $difficultyMap, $x, $y, $x + 1, $y);
    }

    if (isset($map[$y][$x - 1]) && (!isset($difficultyMap[$y][$x - 1]) || $difficultyMap[$y][$x - 1] > $difficultyMap[$y][$x] + $map[$y][$x - 1])) {
        move($map, $difficultyMap, $x, $y, $x - 1, $y);
    }

    if (isset($map[$y + 1][$x]) && (!isset($difficultyMap[$y + 1][$x]) || $difficultyMap[$y + 1][$x] > $difficultyMap[$y][$x] + $map[$y + 1][$x])) {
        move($map, $difficultyMap, $x, $y, $x, $y + 1);
    }

    if (isset($map[$y - 1][$x]) && (!isset($difficultyMap[$y - 1][$x]) || $difficultyMap[$y - 1][$x] > $difficultyMap[$y][$x] + $map[$y - 1][$x])) {
        move($map, $difficultyMap, $x, $y, $x, $y - 1);
    }
}

move($map, $difficultyMap, 0, 0, 1, 0);
move($map, $difficultyMap, 0, 0, 0, 1);

$lastRow = $difficultyMap[max(array_keys($difficultyMap))];

echo $lastRow[max(array_keys($lastRow))];
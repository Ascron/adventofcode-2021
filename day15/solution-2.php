<?php
$map = file('input.txt');
foreach ($map as &$row) {
    $originalRow = str_split(trim($row));
    $row = $originalRow;
    for ($i = 1; $i <= 4; $i++) {
        foreach ($originalRow as $value) {
            $row[] = ($value + $i - 1) % 9 + 1;
        }
    }
}
unset($row);
$originalMap = $map;
for ($i = 1; $i <= 4; $i++) {
    foreach ($originalMap as $row) {
        $biggerRow = [];
        foreach ($row as $value) {
            $biggerRow[] = ($value + $i - 1) % 9 + 1;
        }
        $map[] = $biggerRow;
    }
}

$difficultyMap = [
    0 => [
        0 => 0,
    ]
];

for ($x = 0, $c = count($map[0]) - 1; $x < $c; $x++) {
    $difficultyMap[0][$x + 1] = $difficultyMap[0][$x] + $map[0][$x + 1];
}

for ($y = 0, $maxY = count($map) - 1; $y < $maxY; $y++) {
    for ($x = 0, $maxX = count($map[$y]); $x < $maxX; $x++) {
        $difficultyMap[$y + 1][$x] = $difficultyMap[$y][$x] + $map[$y + 1][$x];
    }
}

//for ($i = 0; $i < 100; $i++) {
//    for ($y = 0, $maxY = count($map); $y < $maxY; $y++) {
//        for ($x = 0, $maxX = count($map[$y]) - 1; $x < $maxX; $x++) {
//            $difficultyMap[$y][$x + 1] = min($difficultyMap[$y][$x] + $map[$y][$x + 1], $difficultyMap[$y][$x + 1]);
//        }
//    }
//
//    for ($y = 0, $maxY = count($map); $y < $maxY; $y++) {
//        for ($x = count($map[$y]) - 1, $maxX = 0; $x > $maxX; $x--) {
//            $difficultyMap[$y][$x - 1] = min($difficultyMap[$y][$x] + $map[$y][$x - 1], $difficultyMap[$y][$x - 1]);
//        }
//    }
//
//    for ($y = count($map) - 1, $maxY = 0; $y > $maxY; $y--) {
//        for ($x = 0, $maxX = count($map[$y]); $x < $maxX; $x++) {
//            $difficultyMap[$y - 1][$x] = min($difficultyMap[$y][$x] + $map[$y - 1][$x], $difficultyMap[$y - 1][$x]);
//        }
//    }
//
//    for ($y = 0, $maxY = count($map) - 1; $y < $maxY; $y++) {
//        for ($x = 0, $maxX = count($map[$y]); $x < $maxX; $x++) {
//            $difficultyMap[$y + 1][$x] = min($difficultyMap[$y][$x] + $map[$y + 1][$x], $difficultyMap[$y + 1][$x]);
//        }
//    }
//
//    echo $i . PHP_EOL;
//}

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
<?php
$file = file('input.txt');
$map = [];
foreach ($file as $row) {
    $map[] = str_split(trim($row));
}
$count = 0;

function moveEast(&$map) {
    $count = 0;
    for ($y = count($map) - 1; $y >= 0; $y--) {
        $temp = $map[$y];
        for ($x = count($map[$y]) - 1; $x >= 0; $x--) {
            $next = ($x + 1) % count($map[$y]);
            if ($temp[$x] == '>' && isset($temp[$next]) && $temp[$next] == '.') {
                $map[$y][$x] = '.';
                $map[$y][$next] = '>';
                $x--;
                $count++;
            }
        }
    }
    return $count;
}

function moveSouth(&$map) {
    $count = 0;
    $temp = $map;
    for ($x = count($map[0]) - 1; $x >= 0; $x--) {
        for ($y = count($map) - 1; $y >= 0; $y--) {
            $next = ($y + 1) % count($map);
            if ($temp[$y][$x] == 'v' && isset($temp[$next][$x]) && $temp[$next][$x] == '.') {
                $map[$y][$x] = '.';
                $map[$next][$x] = 'v';
                $y--;
                $count++;
            }
        }
    }
    return $count;
}

function display($map) {
    foreach ($map as $line) {
        echo implode($line) . PHP_EOL;
    }

    echo PHP_EOL;
}

while (true) {
    $result = moveEast($map);
    $result += moveSouth($map);
    $count++;
    echo $count . PHP_EOL;
//    display($map);
    if (!$result) {
        break;
    }
}

echo $count;
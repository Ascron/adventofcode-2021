<?php
$file = file('input.txt');
$players = [];
foreach ($file as $line) {
    preg_match('#Player (\d) starting position: (\d)#', $line, $matches);
    $players[$matches[1]] = ['place' => [1 => $matches[2] - 1], 'score' => [1 => 0]];
}
$result = [
    1 => 1,
    2 => 1
];

$result = [];
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        for ($k = 1; $k <= 3; $k++) {
            $result[$i + $j + $k] = ($result[$i + $j + $k] ?? 0) + 1;
        }
    }
}


print_r($result);

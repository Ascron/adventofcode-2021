<?php
$file = file('input.txt');
$position = 0;
$depth = 0;
$aim = 0;
foreach ($file as $row) {
    [$cmd, $value] = explode(' ', trim($row));
    switch ($cmd) {
        case 'forward':
            $position += (int)$value;
            $depth += $aim * $value;
            break;
        case 'down':
            $aim += (int)$value;
            break;
        case 'up':
            $aim -= $value;
            break;
    }
}

echo $depth * $position;
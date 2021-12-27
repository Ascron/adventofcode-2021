<?php
$file = file('input.txt');
$position = 0;
$depth = 0;
foreach ($file as $row) {
    [$cmd, $value] = explode(' ', trim($row));
    switch ($cmd) {
        case 'forward':
            $position += (int)$value;
            break;
        case 'down':
            $depth += (int)$value;
            break;
        case 'up':
            $depth -= $value;
            break;
    }
}

echo $depth * $position;
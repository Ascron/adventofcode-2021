<?php
$file = file('input.txt');
$result = [];
$counter = 0;
foreach ($file as $line) {
    [$from, $to] = explode(' -> ', trim($line));
    [$fromX, $fromY] = explode(',', $from);
    [$toX, $toY] = explode(',', $to);
    if ($fromX == $toX || $fromY == $toY) {
        if ($fromX > $toX) {
            [$fromX, $toX] = [$toX, $fromX];
        }

        if ($fromY > $toY) {
            [$fromY, $toY] = [$toY, $fromY];
        }

        for ($x = $fromX; $x <= $toX; $x++) {
            for ($y = $fromY; $y <= $toY; $y++) {
                if (isset($result[$x][$y])) {
                    if ($result[$x][$y] == 1) {
                        $counter++;
                    }
                    $result[$x][$y]++;
                } else {
                    $result[$x][$y] = 1;
                }
            }
        }
    }
}

echo $counter;
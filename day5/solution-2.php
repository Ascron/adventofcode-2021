<?php
$file = file('input.txt');
$result = [];
$counter = 0;
foreach ($file as $line) {
    [$from, $to] = explode(' -> ', trim($line));
    [$fromX, $fromY] = explode(',', $from);
    [$toX, $toY] = explode(',', $to);

    $c = max(abs($toY - $fromY), abs($toX - $fromX));
    for ($i = 0; $i <= $c; $i++) {
        $x = round($fromX + ($toX - $fromX) * $i / $c);
        $y = round($fromY + ($toY - $fromY) * $i / $c);

//        echo 'draw ' . $x .':' . $y . PHP_EOL;
        if (isset($result[$x][$y])) {
            if ($result[$x][$y] == 1) {
                $counter++;
//                echo $x . ':' . $y . PHP_EOL;
            }
            $result[$x][$y]++;
        } else {
            $result[$x][$y] = 1;
        }
    }
}

echo $counter;
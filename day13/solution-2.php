<?php
[$dotsRaw, $foldsRaw] = explode("\n\n", file_get_contents('input.txt'));

$foldsRaw = explode("\n", $foldsRaw);
$paper = [];
$maxX = 0;
$maxY = 0;
foreach (explode("\n", $dotsRaw) as $dot) {
    [$x, $y] = explode(',', trim($dot));
    $paper[$y][$x] = 1;
    $maxX = max($maxX, $x);
    $maxY = max($maxY, $y);
}

function display($paper, $maxX, $maxY) {
    for ($y = 0; $y <= $maxY; $y++) {
        for ($x = 0; $x <= $maxX; $x++) {
            echo isset($paper[$y][$x]) ? '#' : '.';
        }
        echo PHP_EOL;
    }

    echo PHP_EOL;
}

for ($i = 0, $c = count($foldsRaw); $i < $c; $i++) {
    [,,$rule] = explode(' ', $foldsRaw[$i]);
    [$foldType, $foldValue] = explode('=', $rule);

    if ($foldType == 'y') {
        unset($paper[$foldValue]);
        for ($foldIndex = $foldValue + 1; $foldIndex <= $maxY; $foldIndex++) {
            if (isset($paper[$foldIndex])) {
                $foldPosition = 2 * $foldValue - $foldIndex;
                for ($x = 0; $x <= $maxX; $x++) {
                    if (isset($paper[$foldIndex][$x])) {
                        $paper[$foldPosition][$x] = 1;
                    }
                }
                unset($paper[$foldIndex]);
            }
        }
        $maxY = ($maxY - 1) / 2;
    } elseif ($foldType == 'x') {
        foreach ($paper as &$row) {
            if (isset($row[$foldValue])) {
                unset($row[$foldValue]);
            }
            for ($x = $foldValue + 1; $x <= $maxX; $x++) {
                if (isset($row[$x])) {
                    $foldPosition = 2 * $foldValue - $x;
                    $row[$foldPosition] = 1;
                    unset($row[$x]);
                }
            }
        }
        unset($row);
        $maxX = ($maxX - 1) / 2;
    }

//    break;
}

display($paper, $maxX, $maxY);
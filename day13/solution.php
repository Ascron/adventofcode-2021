<?php
[$dotsRaw, $foldsRaw] = explode("\n\n", file_get_contents('input.txt'));

$foldsRaw = explode("\n", $foldsRaw);
$paper = [];
foreach (explode("\n", $dotsRaw) as $dot) {
    [$x, $y] = explode(',', trim($dot));
    $paper[$y][$x] = 1;
}

for ($i = 0, $c = count($foldsRaw); $i < $c; $i++) {
    [,,$rule] = explode(' ', $foldsRaw[$i]);
    [$foldType, $foldValue] = explode('=', $rule);

    if ($foldType == 'y') {
        unset($paper[$foldValue]);
        for ($foldIndex = $foldValue + 1, $foldLength = count($paper); $foldIndex < $foldLength; $foldIndex++) {
            $foldPosition = 2 * $foldValue - $foldIndex;
            for ($x = 0, $width = max(array_keys($paper[$foldIndex])); $x <= $width; $x++) {
                if (isset($paper[$foldIndex][$x])) {
                    $paper[$foldPosition][$x] = 1;
                }
            }
            unset($paper[$foldPosition]);
        }
    } elseif ($foldType == 'x') {
        foreach ($paper as &$row) {
            if (isset($row[$foldValue])) {
                unset($row[$foldValue]);
            }
            for ($x = $foldValue + 1, $width = max(array_keys($row)); $x <= $width; $x++) {
                if (isset($row[$x])) {
                    $foldPosition = 2 * $foldValue - $x;
                    $row[$foldPosition] = 1;
                    unset($row[$x]);
                }
            }
        }
    }

    break;
}
$result = 0;
foreach ($paper as $row) {
    $result += array_sum($row);
}

echo $result;
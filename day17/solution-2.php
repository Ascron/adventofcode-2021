<?php
$targetX = [209, 238];
$targetY = [-86, -59];

$rangeX = range($targetX[0], $targetX[1]);
$rangeY = range($targetY[0], $targetY[1]);
$result = [];
$zeroResult = [];
for ($x = $targetX[1]; $x > 0; $x--) {
    foreach ($rangeX as $target) {
        // steps^2-(2x+1)*steps + 2*target = 0
        $d = pow(2 * $x + 1, 2) - 4 * 2 * $target;
        $x1 = (2 * $x + 1 + sqrt($d)) / 2;
        if (($x1 - floor($x1)) < 0.001 && $x1 < $target) {
            if ($x1 == $x) {
                $zeroResult[$x1][] = $x;
            } elseif ($x1 < $x) {
                $result[$x1][] = $x;
            }
        }
        $x2 = (2 * $x + 1 - sqrt($d)) / 2;
        if (($x2 - floor($x2)) < 0.001 && $x2 < $target) {
            if ($x2 == $x) {
                $zeroResult[$x2][] = $x;
            } elseif ($x2 < $x) {
                $result[$x2][] = $x;
            }
        }
        $z = 1;
    }
}

print_r($result);
print_r($zeroResult);

$resultY = [];

for ($y = $targetY[0]; $y < abs($targetY[0]); $y++) {
    foreach ($rangeY as $target) {
        // steps^2-(2x+1)*steps + 2*target = 0
        $d = pow(2 * $y + 1, 2) - 4 * 2 * $target;
        $y1 = (2 * $y + 1 + sqrt($d)) / 2;
        if (($y1 - floor($y1)) < 0.0001 && $y1 > 0) {
            $resultY[$y1][] = $y;
        }
        $y2 = (2 * $y + 1 - sqrt($d)) / 2;
        if (($y2 - floor($y2)) < 0.0001 && $y2 > 0) {
            $resultY[$y2][] = $y;
        }
        $z = 1;
    }
}

print_r($resultY);
$answer = [];
foreach ($resultY as $steps => $possibleY) {
    if (isset($result[$steps])) {
        foreach ($result[$steps] as $possibleX) {
            foreach ($possibleY as $y) {
                $answer[$possibleX.':'.$y] = [$possibleX, $y, $steps];
            }
        }
    }
}

foreach ($zeroResult as $steps => $possibleX) {
    foreach ($resultY as $stepsY => $possibleY) {
        if ($stepsY >= $steps) {
            foreach ($possibleX as $x) {
                foreach ($possibleY as $y) {
                    $answer[$x.':'.$y] = [$x, $y, $stepsY];
                }
            }
        }
    }
}

echo count($answer);
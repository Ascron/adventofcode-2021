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
                $zeroResult[] = $x1;
            } else {
                $result[] = $x1;
            }
        }
        $x2 = (2 * $x + 1 - sqrt($d)) / 2;
        if (($x2 - floor($x2)) < 0.001 && $x2 < $target) {
            if ($x2 == $x) {
                $zeroResult[] = $x2;
            } else {
                $result[] = $x2;
            }
        }
        $z = 1;
    }
}
$result = array_values(array_unique($result));
sort($result);
print_r($result);
print_r(array_values(array_unique($zeroResult)));

echo (85+85-84) / 2 * 85;
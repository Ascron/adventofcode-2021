<?php
$list = explode(',', trim(file_get_contents('input.txt')));
$min = min($list);
$max = max($list);
$result = [];
for ($i = $min; $i <= $max; $i++) {
    $result[$i] = array_reduce($list, function ($carry, $item) use ($i) {
        $length = abs($item - $i);
        return $carry + (1 + $length) * $length / 2;
    });
}

echo min($result);
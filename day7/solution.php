<?php
$list = explode(',', trim(file_get_contents('input.txt')));

$min = min($list);
$max = max($list);
$result = [];
for ($i = $min; $i <= $max; $i++) {
    $result[$i] = array_reduce($list, function ($carry, $item) use ($i) {
        return $carry + abs($item - $i);
    });
}

echo min($result);
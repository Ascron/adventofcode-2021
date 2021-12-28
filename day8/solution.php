<?php
$file = file('input.txt');
$result = 0;
foreach ($file as $row) {
    [$numbers, $goal] = explode(' | ', trim($row));
    $result += array_reduce(explode(' ', $goal), function ($carry, $item) {
        if (in_array(strlen($item), [2, 3, 4, 7])) {
            $carry++;
        }
        return $carry;
    });
}

echo $result;
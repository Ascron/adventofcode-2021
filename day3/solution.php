<?php
$file = file('input.txt');
$result = [];
$length = count($file);
foreach ($file as $row) {
    $result[] = str_split(trim($row));
}

$result = array_map(function() use ($length) {
    return round(array_sum(func_get_args()) / $length);
}, ...$result);
$result = implode('', $result);
$num = bindec($result);
echo ($num ^ 0b111111111111) * $num;
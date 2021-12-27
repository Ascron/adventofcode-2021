<?php
$file = file('input.txt');
$tempArray = [];
foreach ($file as $key => $row) {
    if ($key - 2 >= 0) {
        $tempArray[$key - 2] = ($tempArray[$key - 2] ?? 0) + $row;
    }
    if ($key - 1 >= 0) {
        $tempArray[$key - 1] = ($tempArray[$key - 1] ?? 0) + $row;
    }
    $tempArray[$key] = ($tempArray[$key] ?? 0) + $row;
}

$counter = 0;
foreach ($tempArray as $key => $row) {
    if (isset($tempArray[$key - 1]) && $row > $tempArray[$key - 1]) {
        $counter++;
    }
}

echo $counter;
<?php
$file = file('input.txt');
$counter = 0;
foreach ($file as $key => $row) {
    if (isset($file[$key - 1]) && $row > $file[$key - 1]) {
        $counter++;
    }
}

echo $counter;
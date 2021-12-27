<?php
$lanternfish = explode(',', trim(file_get_contents('input.txt')));

for ($i = 0; $i < 80; $i++) {
    for ($j = 0, $c = count($lanternfish); $j < $c; $j++) {
        if ($lanternfish[$j]--) {

        } else {
            $lanternfish[$j] = 6;
            $lanternfish[] = 8;
        }
    }
}

echo count($lanternfish);
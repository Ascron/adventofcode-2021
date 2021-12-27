<?php
$lanternfish = array_count_values(explode(',', trim(file_get_contents('input.txt'))));
print_r($lanternfish);

for ($i = 0; $i < 256; $i++) {
    $new = [];
    foreach ($lanternfish as $index => $value) {
        if ($index == 0) {
            $new[8] = ($new[8] ?? 0) + $value;
            $new[6] = ($new[6] ?? 0) + $value;
        } else {
            $new[$index - 1] = ($new[$index - 1]?? 0) + $value;
        }
    }

    $lanternfish = $new;

}



echo array_sum($lanternfish);
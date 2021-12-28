<?php
$file = file('input.txt');
$result = 0;

$table = [
    0 => ['a', 'b', 'c', 'e', 'f', 'g'],
    1 => ['c', 'f'],
    2 => ['a', 'c', 'd', 'e', 'g'],
    3 => ['a', 'c', 'd', 'f', 'g'],
    4 => ['b', 'c', 'd', 'f'],
    5 => ['a', 'b', 'd', 'f', 'g'],
    6 => ['a', 'b', 'd', 'e', 'f', 'g'],
    7 => ['a', 'c', 'f'],
    8 => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
    9 => ['a', 'b', 'c', 'd', 'f', 'g'],
];

foreach ($file as $row) {
    [$numbers, $goal] = explode(' | ', trim($row));
    $letters = array_count_values(str_split(str_replace(' ', '', $numbers)));
    $numbers = explode(' ', $numbers);
    $four = [];
    $one = [];
    foreach ($numbers as $number) {
        if (strlen($number) == 2) {
            $one = str_split($number);
        }
        if (strlen($number) == 4) {
            $four = str_split($number);
        }
    }
    $decode = [];
    foreach ($letters as $letter => $count) {
        $decode[$letter] = match ($count) {
            9 => 'f',
            8 => in_array($letter, $one) ? 'c' : 'a',
            7 => in_array($letter, $four) ? 'd' : 'g',
            6 => 'b',
            4 => 'e'
        };
    }

    $goal = explode(' ', $goal);
    $goalResult = '';
    foreach ($goal as $digit) {
        $digit = str_split($digit);
        $decoded = [];
        foreach ($digit as $letter) {
            $decoded[] = $decode[$letter];
        }

//        print_r($decoded);
        foreach ($table as $digit => $digitArray) {
            if (count($digitArray) == count($decoded) && count(array_intersect($decoded, $digitArray)) == count($digitArray)) {
                $goalResult .= $digit;
            }
        }


    }
    $result += (int)$goalResult;
}

echo $result;
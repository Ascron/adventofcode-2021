<?php
$file = file('input.txt');
$pair = [
    '>' => '<',
    '}' => '{',
    ']' => '[',
    ')' => '(',
];

$score = [
    '(' => 1,
    '[' => 2,
    '{' => 3,
    '<' => 4
];
$result = [];
foreach ($file as $row) {
    $row = str_split(trim($row));
    $check = [];
    foreach ($row as $bracket) {
        if (in_array($bracket, $pair)) {
            array_push($check, $bracket);
        } else {
            if (array_pop($check) != $pair[$bracket]) {
//                $result += $score[$bracket];
                continue 2;
            }
        }
    }

    $checkSum = 0;
    foreach (array_reverse($check) as $bracket) {
        $checkSum *= 5;
        $checkSum += $score[$bracket];
    }
    $result[] = $checkSum;
}
sort($result);
print_r($result);
echo $result[floor(count($result)/2)];
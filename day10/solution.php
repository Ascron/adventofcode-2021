<?php
$file = file('input.txt');
$pair = [
    '>' => '<',
    '}' => '{',
    ']' => '[',
    ')' => '(',
];

$score = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137
];
$result = 0;
foreach ($file as $row) {
    $row = str_split(trim($row));
    $check = [];
    foreach ($row as $bracket) {
        if (in_array($bracket, $pair)) {
            array_push($check, $bracket);
        } else {
            if (array_pop($check) != $pair[$bracket]) {
                $result += $score[$bracket];
                break;
            }
        }
    }
}
echo $result;
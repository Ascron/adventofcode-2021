<?php
$data = file_get_contents('input.txt');
[$key, $image] = explode("\n\n", trim($data));

$imageData = explode("\n", $image);
$result = [];
$maxShift = 50;
foreach ($imageData as $datum) {
    if (!$result) {
        for ($shift = $maxShift; $shift > 0; $shift--) {
            $result[] = array_fill(0, strlen($datum) + $maxShift * 4, 0);
        }
    }

    $datum = str_split(str_replace(['#', '.'], ['1', '0'], $datum));
    foreach ($datum as &$value) {
        $value = (int)$value;
    }
    unset($value);
    for ($shift = $maxShift; $shift > 0; $shift--) {
        array_unshift($datum, 0);
        array_push($datum, 0);
    }

    $result[] = $datum;
}

for ($shift = $maxShift; $shift > 0; $shift--) {
    $result[] = array_fill(0, count($datum) + $maxShift * 4, 0);
}

function getSliceValue($data, $x, $y, $shift) {
    $value = (isset($data[$y - 1][$x - 1]) ? $data[$y - 1][$x - 1] : $shift % 2)
        .(isset($data[$y - 1][$x]) ? $data[$y - 1][$x] : $shift % 2)
        .(isset($data[$y - 1][$x + 1]) ? $data[$y - 1][$x + 1] : $shift % 2)
        .(isset($data[$y][$x - 1]) ? $data[$y][$x - 1] : $shift % 2)
        .(isset($data[$y][$x]) ? $data[$y][$x] : $shift % 2)
        .(isset($data[$y][$x + 1]) ? $data[$y][$x + 1] : $shift % 2)
        .(isset($data[$y + 1][$x - 1]) ? $data[$y + 1][$x - 1] : $shift % 2)
        .(isset($data[$y + 1][$x]) ? $data[$y + 1][$x] : $shift % 2)
        .(isset($data[$y + 1][$x + 1]) ? $data[$y + 1][$x + 1] : $shift % 2);

    return (int)base_convert($value, 2, 10);
}

for ($shift = $maxShift; $shift > 0; $shift--) {
    $output = [];

    for ($y = 0, $c = count($result); $y < $c; $y++) {

        for ($x = 0, $width = count($result[$y]); $x < $width; $x++) {
            $replace = getSliceValue($result, $x, $y, $shift);
            $output[$y][$x] = $key[$replace] == '#' ? 1 : 0;
        }
    }

    $result = $output;
}

$answer = 0;
foreach ($result as $line) {
    $answer += array_sum($line);
}

echo $answer;
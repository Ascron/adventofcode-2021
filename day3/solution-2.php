<?php
$file = file('input.txt');
$result = [];
$length = count($file);
foreach ($file as $row) {
    $result[] = str_split(trim($row));
}

$oxygen = $result;
$co2 = $result;

for ($i = 0; $i < 12; $i++) {
    $oxySum = 0;
    foreach ($oxygen as $item) {
        $oxySum += $item[$i];
    }
    if ($oxySum >= count($oxygen) / 2) {
        $filter = 1;
    } else {
        $filter = 0;
    }

    $oxygen = array_filter($oxygen, function ($item) use ($i, $filter) {
        if ($item[$i] == $filter) {
            return true;
        } else {
            return false;
        }
    });

    if (count($oxygen) == 1) {
        break;
    }
}

for ($i = 0; $i < 12; $i++) {
    $co2Sum = 0;
    foreach ($co2 as $item) {
        $co2Sum += $item[$i];
    }

    if ($co2Sum >= count($co2) / 2) {
        $filter = 0;
    } else {
        $filter = 1;
    }

    $co2 = array_filter($co2, function ($item) use ($i, $filter) {
        if ($item[$i] == $filter) {
            return true;
        } else {
            return false;
        }
    });

    if (count($co2) == 1) {
        break;
    }
}

echo bindec(implode('', reset($oxygen))) * bindec(implode('', reset($co2)));
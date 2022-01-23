<?php
[$startSequence, $rules] = explode("\n\n", file_get_contents('input.txt'));

$rawRules = explode("\n", trim($rules));
$rules = [];
foreach ($rawRules as $rule) {
    [$from, $to] = explode(' -> ', $rule);
    $elements = str_split($from);
    $rules[$from] = [$elements[0] . $to, $to . $elements[1]];
}

$startSequence = str_split(trim($startSequence));
$splitSequence = [];
foreach ($startSequence as $key => $element) {
    if (isset($startSequence[$key + 1])) {
        $sequence = $element . $startSequence[$key + 1];
        $splitSequence[$sequence] =  ($splitSequence[$sequence] ?? 0) + 1;
    }
}

for ($i = 0; $i < 40; $i++) {
    $newSequence = [];
    foreach ($splitSequence as $sequence => $count) {
        foreach ($rules[$sequence] as $product) {
            $newSequence[$product] = ($newSequence[$product] ?? 0) + $count;
        }
    }

    $splitSequence = $newSequence;
}

$result = [];
foreach ($splitSequence as $sequence => $count) {
    foreach (str_split($sequence) as $element) {
        $result[$element] = ($result[$element] ?? 0) + $count / 2;
    }
}

$result['S'] += 0.5;
$result['C'] += 0.5;

print_r($result);

echo max($result) - min($result);
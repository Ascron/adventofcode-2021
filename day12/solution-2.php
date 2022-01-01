<?php
$relations = file('input.txt');

$map = [];

foreach ($relations as &$relation) {
    $relation = explode('-', trim($relation));
    if (!isset($map[$relation[0]])) {
        $map[$relation[0]] = [];
    }

    if (!isset($map[$relation[1]])) {
        $map[$relation[1]] = [];
    }

    if ($relation[1] != 'start') {
        $map[$relation[0]][] = $relation[1];
    }
    if ($relation[0] != 'start') {
        $map[$relation[1]][] = $relation[0];
    }
}
$counter = 0;
function path($map, $path, &$counter) {
    $lastCave = end($path);
    $result = [];
    foreach ($map[$lastCave] as $caveOption) {
        if (
            $caveOption == 'end'
        ) {
//            $counter++;
            echo ++$counter . '-' .implode(',', $path) . ',' . $caveOption . PHP_EOL;
        } else {
            $pathSum = array_count_values($path);
            $limited = false;
            foreach ($pathSum as $item => $count) {
                if (!ctype_upper($item) && $count > 1) {
                    $limited = true;
                    break;
                }
            }
            if (
                ctype_upper($caveOption)
                || (($pathSum[$caveOption] ?? 0) < 1)
                || (($pathSum[$caveOption] ?? 0) < 2 && !$limited)
            ) {
                foreach (path($map, array_merge($path, [$caveOption]), $counter) as $pathOption) {
                    $result[] = $pathOption;
                }
            }
        }
    }

    return $result;
}
path($map, ['start'], $counter);

echo $counter;
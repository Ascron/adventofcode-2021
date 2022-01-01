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

    $map[$relation[0]][] = $relation[1];
    $map[$relation[1]][] = $relation[0];
}

function path($map, $path) {
    $lastCave = end($path);
    $result = [];
    foreach ($map[$lastCave] as $caveOption) {
        if (
            $caveOption == 'end'
        ) {
            $result[] = array_merge($path, [$caveOption]);
        } elseif (
            ctype_upper($caveOption) || !in_array($caveOption, $path)
        ) {
            $result = array_merge($result, path($map, array_merge($path, [$caveOption])));
        }
    }

    return $result;
}
$x = path($map, ['start']);
print_r($x);

echo count($x);
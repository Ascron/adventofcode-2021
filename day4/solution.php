<?php
$boards = explode("\n\n", file_get_contents('input.txt'));

$numbers = explode(',', trim(array_shift($boards)));

foreach ($boards as &$board) {
    $board = explode("\n", $board);
    foreach ($board as &$row) {
        $row = explode(' ', str_replace('  ', ' ', $row));
    }
}
unset($row, $board);

$getRow = function ($board, $index) {
    return $board[$index];
};

$getColumn = function ($board, $index) {
    return array_map(function ($item) use ($index) {
        return $item[$index];
    }, $board);
};

$find = function ($board, $number) {
    $columnIndex = false;
    foreach ($board as $rowIndex => $row) {
        $columnIndex = array_search($number, $row);
        if ($columnIndex !== false) {
            break;
        }
    }

    if ($columnIndex !== false) {
        return [$rowIndex, $columnIndex];
    } else {
        return null;
    }
};

foreach ($numbers as $number) {
    foreach ($boards as $boardIndex => $board) {
        $result = $find($boards[$boardIndex], $number);
        if ($result) {
            [$row, $column] = $result;
            $boards[$boardIndex][$row][$column] = 0;
            if (
                !array_sum($getRow($boards[$boardIndex], $row))
                || !array_sum($getColumn($boards[$boardIndex], $column))
            ) {
                $sum = 0;
                foreach ($boards[$boardIndex] as $row) {
                    $sum += array_sum($row);
                }
                echo $sum * $number;
                break 2;
            }
        }
    }
}

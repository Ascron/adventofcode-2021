<?php

$x = 0;
$y = 0;
$z = 0;

$file = file_get_contents('input.txt');
$programs = explode("inp w\n", $file);
array_shift($programs);

for ($i = 0; $i < 14; $i++) {
    $rawProgram = explode("\n", $programs[$i]);
    $program = [];
    foreach ($rawProgram as $command) {
        $program[] = explode(' ', $command);
    }

    for ($digit = 9; $digit > 0; $digit--) {
        $w = $digit;

        foreach ($program as $command) {
            if (count($command) == 1) {
                continue;
            } else {
                [$cmd, $oper1, $oper2] = $command;
            }

            switch ($cmd) {
                case 'add':
                    ${$oper1} += is_numeric($oper2) ? $oper2 : ${$oper2};
                    break;
                case 'mul':
                    ${$oper1} *= is_numeric($oper2) ? $oper2 : ${$oper2};
                    break;
                case 'div':
                    ${$oper1} = (int)(${$oper1} / (is_numeric($oper2) ? $oper2 : ${$oper2}));
                    break;
                case 'mod':
                    ${$oper1} = ${$oper1} % (is_numeric($oper2) ? $oper2 : ${$oper2});
                    break;
                case 'eql':
                    if (${$oper1} == (is_numeric($oper2) ? $oper2 : ${$oper2})) {
                        ${$oper1} = 1;
                    } else {
                        ${$oper1} = 0;
                    }
                    break;
            }
        }

        $n = 1;
        if ($z == 0) {
            echo $digit;
            continue 2;
        }
    }
}

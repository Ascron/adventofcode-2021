<?php
$file = file('input.txt');
$players = [];
foreach ($file as $line) {
    preg_match('#Player (\d) starting position: (\d)#', $line, $matches);
    $players[$matches[1]] = ['place' => $matches[2] - 1, 'score' => 0];
}

//print_r($players);

$dice = 0;

while (true) {
    foreach ($players as $key => $player) {
        for ($i = 0; $i < 3; $i++) {
            $players[$key]['place'] += $dice++ % 100 + 1;
        }

        $players[$key]['place'] = $players[$key]['place'] % 10;
        $players[$key]['score'] += $players[$key]['place'] + 1;

        if ($players[$key]['score'] >= 1000) {
            $loser = $key ^ 3;
            echo $players[$loser]['score'] * $dice;
            break 2;
        }
    }
}
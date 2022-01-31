<?php
$file = file('input.txt');
$players = [];
foreach ($file as $line) {
    preg_match('#Player (\d) starting position: (\d)#', $line, $matches);
    $players[$matches[1]] = ['place' => $matches[2] - 1, 'score' => 0];
}

$games = [
    ['plays' => 1, 'players' => $players]
];
$result = [
    1 => 1,
    2 => 1
];

$options = [
    3 => 1,
    4 => 3,
    5 => 6,
    6 => 7,
    7 => 6,
    8 => 3,
    9 => 1,
];

function getKey($players) {
    return $players[1]['place'].'.'.$players[1]['score'].'.'.$players[2]['place'].'.'.$players[2]['score'];
}

$newGames = [];
$finished = [];
$player = 1;
$counter = 1;
$result = [1 => 0, 2 => 0];
while (true) {
    while ($currentGame = array_pop($games)) {
        foreach ($options as $points => $option) {
            $newPlayers = $currentGame['players'];
            $newPlayers[$player]['place'] = ($newPlayers[$player]['place'] + $points) % 10;
            $newPlayers[$player]['score'] += $newPlayers[$player]['place'] + 1;
            if ($newPlayers[$player]['score'] >= 21) {
                $result[$player] += $currentGame['plays'] * $option;
            } else {
                $key = getKey($newPlayers);
                if (isset($newGames[$key])) {
                    $newGames[$key]['plays'] += $currentGame['plays'] * $option;
                } else {
                    $newGames[$key] = ['plays' => $currentGame['plays'] * $option, 'players' => $newPlayers];
                }

//                echo $counter++ . PHP_EOL;
            }
        }
    }

    if (!$newGames) {
        break;
    }

    $player = $player ^ 3;
    $games = $newGames;
    $newGames = [];
}

echo max($result);
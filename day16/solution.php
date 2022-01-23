<?php

$content = file_get_contents('input.txt');

$bits = '';
for ($i = 0; $i < strlen($content); $i++) {
    $part = base_convert($content[$i], 16, 2);
    $part = str_pad($part, 4, '0', STR_PAD_LEFT);
    $bits .= $part;
}
//echo strlen($bits); die;
$pointer = 0;

function pull(&$bits, &$pointer, $length, &$fullLength) {
    $result = substr($bits, $pointer, $length);
    $pointer += $length;
    $fullLength += $length;
    return $result;
}

function parse(&$bits, &$pointer): array
{
    $fullLength = 0;
    $version = (int)base_convert(pull($bits, $pointer, 3, $fullLength), 2, 10);
    $id = (int)base_convert(pull($bits, $pointer, 3, $fullLength), 2, 10);

    if ($id == 4) {
        $value = '';
        while (true) {
            $last = pull($bits, $pointer, 1, $fullLength) == '0';
            $value .= pull($bits, $pointer, 4, $fullLength);
            if ($last) {
                break;
            }
        }
        $value = (int)base_convert($value, 2, 10);
        echo $pointer . PHP_EOL;

        return ['version' => $version, 'id' => $id, 'value' => $value, 'length' => $fullLength];
    } else {
        $length = pull($bits, $pointer, 1, $fullLength);
        if ($length == '0') {
            $segmentEnd = (int)base_convert(pull($bits, $pointer, 15, $fullLength), 2, 10) + $pointer;
            $sub = [];
            while ($pointer < $segmentEnd) {
                $subPacket = parse($bits, $pointer);
                $sub[] = $subPacket;
            }

        } elseif ($length == '1') {
            $subPacketCount = (int)base_convert(pull($bits, $pointer, 11, $fullLength), 2, 10);
            $sub = [];
            for ($i = 0; $i < $subPacketCount; $i++) {
                $subPacket = parse($bits, $pointer);
                $sub[] = $subPacket;
            }
        }
        echo $pointer . PHP_EOL;
        return ['version' => $version, 'id' => $id, 'sub' => $sub, 'length' => $fullLength];
    }

}

$packets = parse($bits, $pointer);
$versionSum = 0;
function result($packets) {
    $result = $packets['version'];
    if (isset($packets['sub'])) {
        foreach ($packets['sub'] as $packet) {
            $result += result($packet);
        }

    }
    return $result;
}

echo result($packets);


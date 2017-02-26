<?php
function fetchBytesFromFile($file)
{
    $length = yield;
    $f = fopen($file, 'r');
    while (!feof($f)) {
        $length = yield fread($f, $length);
    }
    yield false;
}

function processBytesInBatch(Generator $byteGenerator)
{
    $buffer = '';
    $bytesNeeded = 1000;
    while ($buffer .= $byteGenerator->send($bytesNeeded)) {
        // determine if buffer has enough data to be executed
        list($lengthOfRecord) = unpack('N', $buffer);
        if (strlen($buffer) < $lengthOfRecord) {
            $bytesNeeded = $lengthOfRecord - strlen($buffer);
            continue;
        }
        yield substr($buffer, 1, $lengthOfRecord);
        $buffer = substr($buffer, 0, $lengthOfRecord + 1);
        $bytesNeeded = 1000 - strlen($buffer);
    }
}

$file = 'readme.md';
$gen = processBytesInBatch(fetchBytesFromFile($file));
foreach ($gen as $record) {
    var_dump($record);
}




















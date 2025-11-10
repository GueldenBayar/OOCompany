<?php

$zahlenfolge = [1, 4, 2, 5];

function tuwas($arr): array
{
    $arr[2] = 17;
    return $arr;
}
$brr = tuwas($zahlenfolge);

print_r($zahlenfolge);
echo '<br>';
print_r($brr);


<?php


$list = [
    ['aaa', 'bbb', 'ccc', 'dddd'],
    ['123', '456', '789'],
    ['"aaa"', '"bbb"']
];

$fp = fopen('file.csv', 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields, ',', '"', '');
}

fclose($fp);


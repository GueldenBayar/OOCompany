<?php

spl_autoload_register(function ($className){
    include 'classes/' . $className . '.php';
});

//getAll

Department::setDepartments();
$departments = Department::getDepartments();
//print_r($departments);

$deppArr = [];
foreach ($departments as $department) {
    $deppArr[] = [$department->getId(), $department->getName()];
}

$fp = fopen('test100.csv', 'w');

foreach ($deppArr as $o) {
    fputcsv($fp, $o, ',', '"', '');
}

fclose($fp);


//echo "<pre>";
//$test = new Department("Product Design");
//var_dump($test);
//echo "</pre>";

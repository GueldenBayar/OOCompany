<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

// Kurzform
$departments = [new Department('HR'),
    new Department('Verkauf'),
    new Department('Produktion')];
echo '<pre>';
print_r($departments);
echo '</pre>';


// ausführliche Form
//$d1 = new Department('HR');
//$d2 = new Department('Verkauf');
//$d3 = new Department('Produktion');
//
//echo '<pre>';
//print_r($d1);
//print_r($d2);
//print_r($d3);
//echo '</pre>';

$e = new Employee(Gender::W, 'Petra', 'Pan', 1);

echo '<pre>';
print_r($e);
echo '</pre>';
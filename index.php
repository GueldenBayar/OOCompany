<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

$d = new Department('blalilu');
$d2 = new Department('shinshano');

print_r($d);
print_r($d2);

die();


// Kurzform
// Department::departments erstellen
Department::setDepartments();

// departments aufrufen
$departments = Department::getDepartments();

//
$employees = Employee::getEmployees();

// Schreibe Funktion(en), die mir angibt, welche Mitarbeiter in 'HR' arbeiten

// Weg: brauche index von HR aus departments
// nehme index und filtere employees mit departmentId = 1

// für index schreibe ich eine Funktion in der Klasse Department
// brauche department-Objekt, um nicht-static Funktionen aufzurufen
$d = $departments[0];
print_r( $d->getByName('HR'));

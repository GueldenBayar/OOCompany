<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

// Kurzform
// Department::departments erstellen
Department::setDepartments();

// departments aufrufen
$departments = Department::getDepartments();


$employees = Employee::getEmployees();

// Schreibe Funktion(en), die mir angibt, welche Mitarbeiter in 'HR' arbeiten

// Weg: brauche index von HR aus departments
// nehme index und filtere employees mit departmentId = 1

// für index schreibe ich eine Funktion in der Klasse Department
// brauche department-Objekt, um nicht-static Funktionen aufzurufen

//print_r (new Department()->getByName('HR'));

Department::setDepartments();
Employee::setEmployees();

foreach (Employee::getEmployees() as $e) {
    echo "{$e->getFirstName()} {$e->getLastName()} ({$e->getGender()}) - Dept ID: {$e->getDepartmentId()}<br>";
}

//$d = (new Department()->getByName('HR'));
//print_r($d);
//echo '<pre>';
//
//print_r(new Employee()->getEmployeesByDepartment($d));
//echo '</pre>';




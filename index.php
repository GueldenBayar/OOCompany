<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

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
echo $d->getIdByName('HR');

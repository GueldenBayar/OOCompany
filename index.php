<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

// Departments einmalig anlegen
Department::setDepartments();
// Employees anlegen (die sich dann selbst ins richtige Department einsortieren)
Employee::setEmployees();

new Employee(Gender::W, "Guhl", "van Hausen", 3);

//Ausgabe aller Mitarbeiter
foreach (Employee::getEmployees() as $e) {
    echo "{$e->getFirstName()} {$e->getLastName()} ({$e->getGender()}) - Dept ID: {$e->getDepartmentId()}<br>";
}


//Ausgabe nach Abteilungen
foreach (Department::getDepartments() as $d) {
    echo "<h3>{$d->getName()}</h3>";
    foreach ($d->getEmployees() as $e) {
        echo "{$e->getFirstName()} {$e->getLastName()} ({$e->getGender()})<br>";
    }
}









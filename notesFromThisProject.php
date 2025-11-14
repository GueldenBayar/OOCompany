<?php

//new Employee(Gender::W, "Guhl", "van Hausen", 3);
//
////Ausgabe aller Mitarbeiter
//foreach (Employee::getEmployees() as $e) {
//    echo "{$e->getFirstName()} {$e->getLastName()} ({$e->getGender()}) - Dept ID: {$e->getDepartmentId()}<br>";
//}
//
//
////Ausgabe nach Abteilungen
//foreach (Department::getDepartments() as $d) {
//    echo "<h3>{$d->getName()}</h3>";
//    foreach ($d->getEmployees() as $e) {
//        echo "{$e->getFirstName()} {$e->getLastName()} ({$e->getGender()})<br>";
//    }
//}


//Die Departments als CSV Datei erstellen
//$departments = Department::getDepartments();
//
//$fp = fopen('file.csv', 'w');
//fputcsv($fp, ['id', 'name'],  ',', '"', '');
//foreach ($departments as $department) {
//    fputcsv($fp, [$department->getId(), $department->getName()], ',', '"', '');
//}
//
//fclose($fp);

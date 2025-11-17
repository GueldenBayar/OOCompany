<?php

spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});

// hartcodierte Departments in Attribut lassen
Department::setDepartments();
// Departments als Array von Objekten auslesen
$departments = Department::getDepartments();
//print_r($departments);

$deppArr = [];
// Attribute von jedem Datensatz auslesen
foreach ($departments as $department) {
    $deppArr[] = [$department->getId(), $department->getName()];
}

$fp = fopen('test100.csv', 'w');

foreach ($deppArr as $o) {
    fputcsv($fp, $o, ',', '"', '');
}

fclose($fp);

echo 'csv-Datei auslesen<br>';

$filename = __DIR__ . '/test100.csv';

if (($handle = fopen($filename, "r")) !== false) {

    $deppArr = [];

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {

        // CSV: [id, name]
        // Konstruktor: __construct(string $name, ?int $id = null)

        $d = new Department($data[1], (int)$data[0]);

        $deppArr[] = $d;
    }

    fclose($handle);

} else {
    echo 'else';
}


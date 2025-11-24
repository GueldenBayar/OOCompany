<?php

spl_autoload_register(function ($class) {
    $path = __DIR__ . "/classes/" . $class . ".php";

    if (file_exists($path)) {
        require_once $path;
    }
});

// Departments und Employees einmalig anlegen
Department::setDepartments();
Employee::setEmployees();

//was will der user? Router
$action = $_GET['action'] ?? 'home';
$content = "";

//HTML code in die variable $content schreiben .= , somit bleibt mein html code unten sauber
switch ($action) {

    case 'home':
        $content .= "<h1>Welcome :)</h1>";
        break;

    case 'departments':
        //Start der Tabelle
        $content .= "<h1>Departments</h1>";

        $departments = Department::getDepartments();

        $tabelleDaten = [];
        //Schleife durch alle Abteilungen
        foreach ($departments as $d) {
            $tabelleDaten[] = [
                    $d->getId(),
                    $d->getName()
            ];
        }
        if (count($tabelleDaten) > 0) {
            $content .= HtmlHelper::baueTabelle(
                    ['ID', 'Name'],
                    $tabelleDaten,
                    'edit_dept',
                    'delete_dept'
            );
        } else {
            $content .= "<p>Keine Abteilungen gefunden.</p>";
        }

        $content .= "<br><a href='index.php?action=new_dept' class='btn'>+new Department</a>";
        break;


    case 'employees':
        $content .= "<h1>Employees</h1>";
        $employees = Employee::getEmployees();

        $tabelleDaten = [];

        foreach ($employees as $e) {
            //Wir suchen Abteilungsnamen mit unserem neuen Helfer
            $deptObject = Department::getById($e->getDepartmentId());
            //Wenn gefunden, nimm den Namen, sonst "not found"
            $deptName = $deptObject ? $deptObject->getName() : 'not found';

            $tabelleDaten[] = [
                    $e->getId(),
                    $e->getFirstName(),
                    $e->getLastName(),
                    $e->getGender(),
                    $deptName
            ];
        }
        if (count($tabelleDaten) > 0) {
            $content .= HtmlHelper::baueTabelle(
                    ['ID', 'Name', 'Gender', 'Department'],
                    $tabelleDaten,
                    'edit_emp',
                    'delete_emp'
            );
        } else {
            $content .= "<p>Keine Mitarbeiter gefunden.</p>";
        }
        $content .= "<br><a href='index.php?action=new_employee' class='btn'>+ Neuer Mitarbeiter</a>";
        break;


    // --- NEW DEPARTMENT ---
    case 'new_dept':
        // wurde das Formular abgeschickt?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['dept_name'];
            //neue Abteilung landet im Array
            if ($name !== '') {
                new Department($name);
            }
            header('Location: index.php?action=departments');
            exit;
        }

        //Formular anzeigen
        $content .= "<h1>New Department</h1>";
        $content .= "<form action='index.php?action=new_dept' method='POST'>";

        $content .= "Name: <input type='text' name='dept_name' required><br><br>";
        $content .= "<button type='submit' class='btn'>Save</button>";
        $content .= "</form>";
        break;

    //Abteilung bearbeiten
    case 'edit_dept':
        //welche ID wollen wir bearbeiten?
        $id = (int)($_GET['id'] ?? 0);
        $dept = Department::getById($id);

        if (!$dept) {
            $content .= "Department not found";
            break;
        }

        //speichern
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['dept_name'] ?? '';
            if ($newName !== '') {
                $dept->setName($newName);
            }
            header('Location:index.php?action=departments');
            exit;
        }

        //Formular mit alten Daten vorbefüllen
        $content .= "<h1>Edit Department</h1>";
        //wichtig: action muss die id behalten!
        $content .= "<form action='index.php?action=edit_dept&id=$id' method='POST'>";
        $content .= "Name <input type='text' name='dept_name' value='" . htmlspecialchars($dept->getName()) . "' required><br><br>";
        $content .= "<button type='submit' class='btn'>Save changes</button>";
        $content .= "</form>";
        break;

    case 'delete_dept':
        $id = (int)($_GET['id'] ?? 0);
        Department::deleteById($id);
        header('Location: index.php?action=departments');
        exit;
        break;

    // --- NEW EMPLOYEE ---
    case 'new_employee':
        //alle Dept für das Dropdown Menü
        $allDepts = Department::getDepartments();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Daten aus dem Formular holen
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $deptId = (int)$_POST['deptId'] ?? 0;

            // Gender: Wert senden, zB weibl
            $genderVal = $_POST['gender'] ?? '';

            // tryFrom: sicherer, falls falscher Wert kommt
            $genderEnum = Gender::tryFrom($genderVal) ?? null;

            new Employee($genderEnum, $firstName, $lastName, $deptId);

            header('Location: index.php?action=employees');
            exit;
        }

        $content .= "<h1>New Employee</h1>";
        $content .= "<form action='index.php?action=new_employee' method='POST'>";
        $content .= "First Name: <input type='text' name='firstName' required><br>";
        $content .= "Last Name: <input type='text' name='lastName' required><br>";

        //Dropdown Gender
        $content .= "Gender: <select name='gender'>";
        $content .= "<option value='" . Gender::W->value . "'>Female</option>";
        $content .= "<option value='" . Gender::M->value . "'>Male</option>";
        $content .= "<option value='" . Gender::D->value . "'>Divers</option>";
        $content .= "</select><br>";

        //Dropdown Departments, dynamisch
        $content .= "Abteilung: <select name='deptId'>";
        foreach ($allDepts as $d) {
            $content .= "<option value='" . $d->getId() . "'>" . htmlspecialchars($d->getName()) . "</option>";
        }
        $content .= "</select><br><br>";

        $content .= "<button type='submit' class='btn'>New</button>";
        $content .= "</form>";
        break;

    //Edit Employee
    case 'edit_emp':
        $id = (int)($_GET['id'] ?? 0);
        $emp = Employee::getById($id);
        $allDepts = Department::getDepartments(); //für das Dropdown Menü

        if (!$emp) {
            $content .= "Employee not found!";
            break;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emp->setFirstName($_POST['firstName'] ?? '');
            $emp->setLastName($_POST['lastName'] ?? '');
            $emp->setDepartmentId((int)$_POST['deptId'] ?? 0);
            $genderVal = $_POST['gender'] ?? '';
            $genderEnum = Gender::tryFrom($genderVal) ?? $emp->getGender();
            if ($genderEnum instanceof Gender) {
                $emp->setGender($genderEnum);
            }
            header('Location: index.php?action=employees');
            exit;
        }

        $content .= "<h1>Edit Employee</h1>";
        $content .= "<form action='index.php?action=edit_emp&id=$id' method='POST'>";

        //Vorbefüllen der Textfelder
        $content .= "First Name: <input type='text' name='firstName' value='" . $emp->getFirstName() . "'><br>";
        $content .= "Last Name: <input type='text' name='lastName' value='" . $emp->getLastName() . "'><br>";

        //Vorbefüllen Abteilung Dropdown
        $selW = ($emp->getGender() === Gender::W->value) ? 'selected' : '';
        $selM = ($emp->getGender() === Gender::M->value) ? 'selected' : '';
        $selD = ($emp->getGender() === Gender::D->value) ? 'selected' : '';

        $content .= "Gender: <select name='gender'>";
        $content .= "<option value='" . Gender::W->value . "' $selW>Female</option>";
        $content .= "<option value='" . Gender::M->value . "' $selM>Male</option>";
        $content .= "<option value='" . Gender::D->value . "' $selD>Divers</option>";
        $content .= "</select><br>";

        //Vorbefüllen Departments dropdown
        $content .= "Department: <select name='deptId'>";
        foreach ($allDepts as $d) {
            //ist das die richtige Abteilung des Mitarbeiters, dann wähle sie aus
            $isSelected = ($d->getId() === $emp->getDepartmentId()) ? 'selected' : '';
            $content .= "<option value='" . $d->getId() . "' $isSelected>" . $d->getName() . "</option>";
        }
        $content .= "</select><br><br>";

        $content .= "<button type='submit' class='btn'>Save</button>";
        $content .= "</form>";
        break;

        // --- Delete Employee ---
    case 'delete_emp':
        $id = (int)($_GET['id'] ?? 0);
        Employee::deleteById($id);
        header('Location: index.php?action=employees');
        exit;
        break;

    default:
        $content .= "<h1>page not found :( </h1>";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employees && Departments</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        nav {
            background-color: #eee;
            padding: 10px;
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 20px;
            text-decoration: none;
            color: black;
        }

        nav a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            background: #ddd;
            text-decoration: none;
            border: 1px solid #ccc;
            color: black;
        }
    </style>
</head>
<body>
<nav>
    <a href="index.php?action=departments">Departments</a>
    <a href="index.php?action=employees">Employees</a>
</nav>
<div>
    <?= $content ?>
</div>


</body>
</html>









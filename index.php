<?php

include 'classes/Department.php';
include 'classes/Gender.php';
include 'classes/Employee.php';

// Departments einmalig anlegen
Department::setDepartments();
// Employees anlegen (die sich dann selbst ins richtige Department einsortieren)
Employee::setEmployees();

//was will der user? (router)
$action = $_GET['action'] ?? 'home';
$content = "";

//HTML code in die variable $content schreiben .= , somit bleibt mein html code unten sauber
switch($action) {

    case 'home':
        $content .= "<h1>Welcome :)</h1>";
//        $content .= "<p>Please select</p>";
        break;

    case 'departments':
        $departments = Department::getDepartments();

        //Start der Tabelle
        $content .= "<h1>Departments</h1>";
        $content .= "<table>";
        $content .= "<thead><tr> <th>ID</th> <th>Name</th> <th>Action</th> </tr></thead>";
        $content .= "<tbody>";

        //Schleife durch alle Abteilungen
        foreach($departments as $d) {
            $content .= "<tr>";
            $content .= "<td>" . $d->getId() . "</td>";
            $content .= "<td>" . $d->getName() . "</td>";

            //Action Buttons (link mit ID)
            $content .= "<td>";
            $content .= "<a href='index.php?action=edit_dept&id=" . $d->getId() . "'>Bearbeiten</a> | ";
            $content .= "<a href='index.php?action=delete_dept&id=" . $d->getId() . "' onclick='return confirm(\"really delete?\")'>Delete</a> ";
            $content .= "</tr>";
        }

        $content .= "</tbody>";
        $content .= "</table>";

        //Button new Department
        $content .= "<br><a href='index.php?action=new_dept' class='btn'>+new Department</a>";
        break;

    case 'employees':
        $employees = Employee::getEmployees();

        $content .= "<h1>Employees</h1>";
        $content .= "<table>";
        $content .= "<thead><tr> <th>Name</th> <th>Gender</th> <th>Department</th> <th>Action</th> </tr></thead>";
        $content .= "<tbody>";

        foreach ($employees as $e) {
            //Wir suchen Abteilungsnamen mit unserem neuen Helfer
            $deptObject = Department::getById($e->getDepartmentId());
            //Wenn gefunden, nimm den Namen, sonst "not found"
            $deptName = $deptObject ? $deptObject->getName() : 'not found';

            $content .= "<tr>";
            //Namen zusammenbauen
            $content .= "<td>" . $e->getFirstName() . " " . $e->getLastName() . "</td>";
            $content .= "<td>" . $e->getGender() . "</td>";
            $content .= "<td>" . $deptName . "</td>";

            $content .= "<td>";
            $content .= "<a href='index.php?action=edit_emp&id=" . $e->getId() . "'>Edit</a> | ";
            $content .= "<a href='index.php?action=delete_emp&id=" . $e->getId() . "' onclick='return confirm(\"really delete?\")'>Delete</a>";
            $content .= "</td>";
            $content .= "</tr>";
        }

            $content .= "</tbody>";
            $content .= "</table>";

            $content .= "<br><a href='index.php?action=new_employee' class='btn'>+ Neuer Mitarbeiter</a>";
        break;

        //NEW DEPARTMENT-------------------
    case 'new_dept':
        //wurde das formular abgeschickt?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['dept_name'];
            //neue Abteilung erstellen (landet im Array)
            new Department($name);

            //zurück zur Liste leiten
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

        if(!$dept) {
            $content .= "Department not found";
            break;
        }

        //speichern
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['dept_name'];
            $dept->setName($newName);//Namen im Objekt ändern

            header('Location:index.php?action=departments');
            exit;
        }

        //Formular mit alten Daten vorbefüllen
        $content .= "<h1>Edit Department</h1>";
        //wichtig: action muss die id behalten!
        $content .="<form action='index.php?action=edit_dept&id=$id' method='POST'>";
        $content .= "Name <input type='text' name='dept_name' value='" . $dept->getName() . "' required><br><br>";
        $content .= "<button type='submit' class='btn'>Save changes</button>";
        $content .= "</form>";
        break;

        //NEW EMPLOYEE-------------------------
    case 'new_employee':
        //alle Dept für das Dropdown Menü
        $allDepts = Department::getDepartments();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Daten aus dem Formular holen
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $deptId = (int)$_POST['deptId'];

            //Gender ist tricky, weil es ein enum ist --> String (zB "W") zurück in enum umwandeln
            $genderEnum = Gender::from($_POST['gender']);

            new Employee($genderEnum, $firstName, $lastName, $deptId);

            header('Location: index.php?action=employees');
            exit;
        }

        $content .= "<h1>New Employee</h1>";
        $content .= "<form action='index.php?action=new_employee' method='POST'";
        $content .= "<input type='text' name='firstName' required><br>";
        $content .= "<input type='text' name='lastName' required><br>";

        //Dropdown Gender
        $content .= "Gender: <select name='gender'>";
        $content .= "<option value='female'>Female</option>";
        $content .= "<option value='male'>Male</option>";
        $content .= "<option value='divers'>Divers</option>";
        $content .= "</select>";

        //Dropdown Departments, dynamisch
        $content .= "Abteilung: <select name='deptId'>";
        foreach ($allDepts as $d) {
            $content .= "<option value='" . $d->getId() . "'>" . $d->getName() . "</option>";
        }
            $content .= "</select><br><br>";

        $content .= "<button type='submit' class='btn'>Anlegen</button>";
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

        if ($_SERVER['REQUEST_METHOD' === 'POST']) {
            $emp->setFirstName($_POST['firstName']);
            $emp->setLastName($_POST['lastName']);
            $emp->setDepartmentId((int)$_POST['deptId']);
            $emp->setGender(Gender::from($_POST['gender']));

            header('Location: index.php?action=employees');
            exit;
        }

        $content .= "<h1>Edit Employee</h1>";
        $content .= "<form action='index.php?action=edit_emp&id=$id' method='POST'>";

        //Vorbefüllen der Textfelder
        $content .= "First Name: <input type='text' name='firstName' value='" .$emp->getFirstName() . "'><br>";
        $content .= "Last Name: <input type='text' name='lastName' value='" . $emp->getLastName() . "'><br>";

        //Vorbefüllen Abteilung Dropdown
        $selW = ($emp->getGender() == 'female') ? 'selected' : '';
        $selM = ($emp->getGender() == 'male') ? 'selected' : '';
        $selD = ($emp->getGender() == 'divers') ? 'selected' : '';

        $content .= "Gender: <select name='gender'>";
        $content .= "<option value='W' $selW>Female</option>";
        $content .= "<option value='M' $selM>Male</option>";
        $content .= "<option value='D' $selD>Divers</option>";
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









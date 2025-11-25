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
//null coalescing operator; Vergleicht, ob $_GET['action'] isset and not null dann bekommt $action die $_GET['action']
//if (isset($_GET['action'])) {
//    $action = $_GET['action'];
//} else {
//    $action = 'home';
//}
$action = $_GET['action'] ?? 'home';
$viewParams = [];
$viewPath = 'views/home.php'; // Standard View

//HTML code in die variable $content schreiben .= , somit bleibt mein html code unten sauber
switch ($action) {

    case 'home':
        $viewPath = 'views/home.php';
        break;

    case 'departments':
        $departments = Department::getDepartments();
        $tabelleDaten = [];
        //Schleife durch alle Abteilungen
        foreach ($departments as $d) {
            $tabelleDaten[] = [
                    $d->getId(),
                    $d->getName()
            ];
        }
        // Daten für View vorbereiten
        $viewParams['tableHtml'] = '';
        if (count($tabelleDaten) > 0) {
            $viewParams['tableHtml'] = HtmlHelper::baueTabelle(
                    ['ID', 'Name'],
                    $tabelleDaten,
                    'edit_dept',
                    'delete_dept'
            );
        }

        $viewPath = 'views/department_list.php';
        break;

    case 'employees':
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

        $viewParams['tableHtml'] = '';
        if (count($tabelleDaten) > 0) {
            $viewParams['tableHtml'] = HtmlHelper::baueTabelle(
                    ['ID', 'Name', 'Gender', 'Department'], $tabelleDaten, 'edit_emp', 'delete_emp'
            );
        }
        $viewPath = 'views/employee_list.php';
        break;

    case 'new_dept':
        // wurde das Formular abgeschickt?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['dept_name'] ?? '';
            //neue Abteilung landet im Array
            if ($name !== '') new Department($name);
            header('Location: index.php?action=departments');
            exit;
        }

        $viewPath = 'views/department_form.php';
        // Setze Variablen für das Formular leer bei Neu
        $viewParams['headline'] = 'New Department';
        $viewParams['formAction'] = 'index.php?action=new_dept';
        $viewParams['deptName'] = '';
        break;

    case 'edit_dept':
        //welche ID wollen wir bearbeiten?
        $id = (int)($_GET['id'] ?? 0);
        $dept = Department::getById($id);

        if (!$dept) {
            $viewPath = 'views/404.php';
            break;
        }

        //speichern
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['dept_name'] ?? '';
            if ($newName !== '') $dept->setName($newName);
            header('Location:index.php?action=departments');
            exit;
        }

        $viewPath = 'views/department_form.php';
        // Wiederverwendung des Formular-Views
        $viewParams['headline'] = 'Edit Department';
        $viewParams['formAction'] = "index.php?action=edit_dept&id=$id";
        $viewParams['deptName'] = $dept->getName();
        break;

    case 'delete_dept':
        $id = (int)($_GET['id'] ?? 0);
        Department::deleteById($id);
        header('Location: index.php?action=departments');
        exit;

    case 'new_employee':
        //alle Dept für das Dropdown Menü
//        $allDepts = Department::getDepartments();
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

        $viewPath = 'views/employee_form.php';
        $viewParams['headline'] = 'New Employee';
        $viewParams['formAction'] = 'index.php?action=new_employee';
        $viewParams['emp'] = null; // Kein Mitarbeiter Objekt vorhanden
        $viewParams['allDepts'] = Department::getDepartments();
        break;

    case 'edit_emp':
        $id = (int)($_GET['id'] ?? 0);
        $emp = Employee::getById($id);
        //allDepts = Department::getDepartments(); //für das Dropdown Menü

        if (!$emp) {
            $viewPath = 'views/404.php';
            break;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emp->setFirstName($_POST['firstName'] ?? '');
            $emp->setLastName($_POST['lastName'] ?? '');
            $emp->setDepartmentId((int)$_POST['deptId'] ?? 0);
            $genderVal = $_POST['gender'] ?? '';
            $genderEnum = Gender::tryFrom($genderVal) ?? $emp->getGender();
            if ($genderEnum instanceof Gender) $emp->setGender($genderEnum);

            header('Location: index.php?action=employees');
            exit;
        }

        $viewPath = 'views/employee_form.php';
        $viewsParams['headline'] = 'Edit Employee';
        $viewsParams['formAction'] = 'index.php?action=edit_emp&id=$id';
        $viewParams['emp'] = $emp;
        $viewParams['allDepts'] = Department::getDepartments();
        break;

    case 'delete_emp':
        $id = (int)($_GET['id'] ?? 0);
        Employee::deleteById($id);
        header('Location: index.php?action=employees');
        exit;

    default:
        $viewPath = 'views/404.php';
}

// Hier entpacken wir das Array in echte Variablen
// z.B. wird $viewParams['headline'] zu $headline
extract($viewParams);

// Layout laden, das Layout lädt dann den $viewPath
require 'views/layout.php';

?>

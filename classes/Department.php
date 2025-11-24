<?php

class Department
{
    private int $id;
    private ?string $name;
    static int $counter = 0;
    static array $departments = [];
    private array $employees = [];

    /**
     * @param string $name
     */
    public function __construct(string $name = null, ?int $id = null)
    {
        if (isset ($name)) {

            $this->name = $name;
            if (!isset($id)) {
                self::$counter++;
                $this->id = self::$counter;
            } else {
                $this->id = $id;
                // sicherstellen, dass counter mindestens id ist um duplikate zu vermeiden
                if ($id > self::$counter) {
                    self::$counter = $id;
                }
            }
            self::$departments[] = $this;
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;

    }

// alle departments als Array erstellen und in self $departments schreiben
    public static function setDepartments(): void
    {
        //nur einmal aufrufen, Initialisierung
        if (count(self::$departments) === 0) {
            new Department('HR');
            new Department('Verkauf');
            new Department('Produktion');
            new Department('play with dog');
        }
    }

    /**
     * @return Department[]
     */
    public static function getDepartments(): array
    {
        return self::$departments;
    }

//    public function getByName(string $name): ?Department
//    {
//        $d = null;
//        $departments = self::getDepartments();
//        echo '<pre>';
//        print_r($departments);
//        echo '</pre>';
//        foreach ($departments as $department) {
//
//            if ($department->getName() === $name) {
//                $d = $department;
//            }
//        }
//        return $d;
//    }

    public function addEmployee(Employee $employee): void
    {
        $this->employees[] = $employee;
    }

    public function getEmployees(): array
    {
        return $this->employees;
    }

    public static function getById(int $id): ?Department
    {
        foreach (self::$departments as $department) {
            if ($department->getId() === $id) {
                return $department;
            }
        }
        return null;
    }

    // Löscht ein Department und entfernt Relation zu Employees
    public static function deleteById(int $id): void {
        foreach (self::$departments as $idx => $department) {
            if ($department -> getId() === $id) {
                //Mitarbeiter, die zu dieser Abteilung gehören löschen
                Employee::deleteByDepartment($id);

                // Department entfernen
                array_splice(self::$departments, $idx, 1);
                return;
            }
        }
    }
}
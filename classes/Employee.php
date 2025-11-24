<?php

class Employee
{
    private ?int $id;
    private ?Gender $gender;
    private ?string $firstName;
    private ?string $lastName;
    private ?int $departmentId;
    static int $counter = 0;

    static array $employees = [];

    public function __construct(?Gender $gender = null, ?string $firstName = null, ?string $lastName = null, ?int $departmentId = null)
    {
        $this->gender = $gender;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->departmentId = $departmentId;

        self::$counter++;
        $this->id = self::$counter;

        self::$employees[] = $this;

        //neuen Mitarbeiter dem Department hinzufügen
        $this->assignToDepartment();
    }

    private function assignToDepartment(): void
    {
        foreach (Department::getDepartments() as $department) {
            if ($department->getId() === $this->departmentId) {
                $department->addEmployee($this);
                break;
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender?->value ?? '';
    }

    /**
     * @param Gender $gender
     */
    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param int $departmentId
     */
    public function setDepartmentId(int $departmentId): void
    {
        $this->departmentId = $departmentId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    public static function setEmployees(): void
    {
        //Beispiel Mitarbeiter nur einmal
        if (count(self::$employees) === 0) {
            new Employee(Gender::W, 'Petra', 'Pan', 1);
            new Employee(Gender::M, 'Peter', 'Pan', 2);
            new Employee(Gender::D, 'Hans', 'Hanso', 3);
            new Employee(Gender::W, 'Tom', 'Tomlinson', 1);
            new Employee(Gender::D, 'Hansi', 'Hansonson', 3);
            new Employee(Gender::W, 'Bruni', 'Banani', 2);
        }
    }

    /**
     * @return Employee[]
     */
    public static function getEmployees(): array
    {
        return self::$employees;
    }

    public static function deleteByDepartmentId(int $departmentId): void {
        //löscht alle Mitarbeiter mit dieser AbteilungsId
        foreach (self::employees as $idx => $employee) {
            if ($employee->getDepartmentId() === $departmentId) {
                array_splice(self::$employees, $idx, 1);
                // ein element wurde entfernt, indexes wurden versetzt - der loop beginnt von vorne
                self::deleteByDepartmentId($departmentId);
                return;
            }
        }
    }

    public static function deleteById(int $id):void {
        foreach (self::employees as $idx => $employee) {
            if ($employee->getId() === $id) {
                array_splice(self::$employees, $idx, 1);
                return;
            }
        }
    }

    /**
     * @param Department $department
     * @return Employee[]
     */
    public function getEmployeesByDepartments(Department $department): array
    {
        $emps = [];
        foreach (self::getEmployees() as $employee) {
            if ($department->getId() === $employee->getDepartmentId()) {
                $emps[] = $employee;
            }
        }
        return $emps;
    }

    //Mitarbeiter, der bearbeitet werden soll finden:
    public static function getById(int $id): ?Employee
    {
        foreach (self::$employees as $employee) {
            if ($employee->getId() === $id) {
                return $employee;
            }
        }
        return null;
    }
}
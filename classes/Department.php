<?php

class Department
{
    // wie PK
    private int $id;

    private ?string $name;

    static int $counter = 0;

    static array $departments = [];

    private array $employees = [];

    /**
     * @param string $name
     */
    public function __construct(?string $name = null)
    {
        if (isset ($name)) {

            $this->name = $name;
            self::$counter++;
            $this->id = self::$counter;
            self::$departments[] = $this;
        }
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
        new Department('HR');
        new Department('Verkauf');
        new Department('Produktion');
        new Department('play with dog');
    }

    // alle erstellten departments auslesen

    /**
     * @return Department[]
     */
    public static function getDepartments(): array{
        return self::$departments;
    }

    public function getByName(string $name): ?Department
    {
        $d = null;
        $departments = self::getDepartments();
        echo '<pre>';
        print_r($departments);
        echo '</pre>';
        foreach ($departments as $department) {

            if ($department->getName() === $name) {
                $d = $department;
            }
        }
        return $d;
    }

    public function addEmployee(Employee $employee): void{
        $this->employees[] = $employee;
    }

    public function getEmployees(): array {
        return $this->employees;
    }

}
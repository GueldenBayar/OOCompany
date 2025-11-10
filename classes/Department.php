<?php

class Department
{
    // wie PK
    private int $id;

    private string $name;

    static int $counter = 0;

    static array $departments = [];

    /**
     * @param string $name
     */
    public static function createDepartment(string $name)
    {
        $d = new Department();
        $d->name = $name;
        self::$counter++;
        $d->id = self::$counter;
        self::$departments[] = $d;
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
        self::createDepartment('HR');
        self::createDepartment('Verkauf');
        self::createDepartment('Produktion');
    }

    // alle erstellten departments auslesen
    public static function getDepartments(): array{
        return self::$departments;
    }

    public function getIdByName(string $name): int
    {
        $departments = self::getDepartments();
        echo '<pre>';
        print_r($departments);
        echo '</pre>';
        foreach ($departments as $department) {
            if ($department->getName() === $name) {
                return $department->getId();
            }
            return 0;
        }
    }

}
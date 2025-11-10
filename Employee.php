<?php

class Employee
{

    private int $id;
    private Gender $gender;
    private string $firstName;
    private string $lastName;
    private int $departmentId;
    static int $counter = 0;

    /**
     * @param Gender $gender
     * @param string $firstName
     * @param string $lastName
     * @param int $departmentId
     */
    public function __construct(Gender $gender, string $firstName, string $lastName, int $departmentId)
    {
        $this->gender = $gender;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->departmentId = $departmentId;
        self::$counter++;
        $this->id = self::$counter;
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
        return $this->gender->value;
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



}
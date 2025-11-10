<?php

class Department
{
    // wie PK
    private int $id;

    private string $name;

    static int $counter = 0;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        self::$counter++;
        $this->id = self::$counter;
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


}
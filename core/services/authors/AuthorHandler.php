<?php

namespace core\services\authors;

use DateTime;

class AuthorHandler
{
    private string $name;
    private string $birthdate;
    private string $biography;
    private int $status;

    /**
     * @param string $name
     * @param string $birthdate
     * @param string $biography
     * @param int $status
     */
    public function __construct(string $name, string $birthdate, string $biography, int $status)
    {
        $this->name = $name;
        $this->birthdate = $birthdate;
        $this->biography = $biography;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
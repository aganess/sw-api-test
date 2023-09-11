<?php

namespace core\services\genres;

class GenreHandler
{
    private string $genreName;
    private int $status;

    /**
     * @param string $genreName
     * @param int $status
     */
    public function __construct(string $genreName, int $status)
    {
        $this->genreName = $genreName;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getGenreName(): string
    {
        return $this->genreName;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
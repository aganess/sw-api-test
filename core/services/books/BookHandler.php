<?php

namespace core\services\books;

class BookHandler
{
    private int $authorId;
    private int $languageId;
    private int $genreId;
    private string $name;
    private string $description;
    private int $numPages;
    private int $status;


    public function __construct(int $authorId, int $languageId, int $genreId, string $name, string $description, int $numPages, int $status)
    {
        $this->authorId = $authorId;
        $this->languageId = $languageId;
        $this->genreId = $genreId;
        $this->name = $name;
        $this->description = $description;
        $this->numPages = $numPages;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getNumPages(): int
    {
        return $this->numPages;
    }
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
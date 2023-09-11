<?php

namespace core\services\languages;

class LanguageHandler
{
    private string $languageName;
    private string $isoCode;
    private int $status;

    /**
     * @param string $languageName
     * @param string $isoCode
     * @param int $status
     */
    public function __construct(string $languageName, string $isoCode, int $status)
    {
        $this->languageName = $languageName;
        $this->isoCode = $isoCode;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getLanguageName(): string
    {
        return $this->languageName;
    }

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
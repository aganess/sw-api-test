<?php

namespace core\services\languages;

use core\entities\Languages;
use core\repositories\LanguageRepository;
use yii\db\StaleObjectException;

class LanguageService
{
    private LanguageRepository $languageRepository;

    /**
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param LanguageHandler $languageHandler
     * @return Languages
     */
    public function add(LanguageHandler $languageHandler): Languages
    {
        $entity = Languages::make($languageHandler->getLanguageName(), $languageHandler->getIsoCode(), $languageHandler->getStatus());
        $this->languageRepository->save($entity);

        return $entity;
    }

    /**
     * @param Languages $entity
     * @param LanguageHandler $languageHandler
     * @return Languages
     */
    public function edit(Languages $entity, LanguageHandler $languageHandler): Languages
    {
        $entity->edit($languageHandler->getLanguageName(), $languageHandler->getIsoCode(), $languageHandler->getStatus());
        $this->languageRepository->save($entity);

        return $entity;
    }

    /**
     * @param Languages $language
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove(Languages $language)
    {
        $this->languageRepository->delete($language);
    }
}
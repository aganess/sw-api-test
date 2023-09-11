<?php

namespace core\services\authors;

use core\entities\Authors;
use core\repositories\AuthorRepository;
use Faker\Provider\DateTime;
use yii\db\StaleObjectException;

class AuthorService
{
    private AuthorRepository $authorRepository;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param AuthorHandler $authorHandle
     * @return Authors
     */
    public function add(AuthorHandler $authorHandle): Authors
    {
        $entity = Authors::make($authorHandle->getName(), $authorHandle->getBirthdate(), $authorHandle->getBiography(), $authorHandle->getStatus());
        $this->authorRepository->save($entity);
        return $entity;
    }

    /**
     * @param Authors $entity
     * @param AuthorHandler $authorHandle
     * @return Authors
     */
    public function edit(Authors $entity, AuthorHandler $authorHandle): Authors
    {
        $entity->edit($authorHandle->getName(), $authorHandle->getBirthdate(), $authorHandle->getBiography(), $authorHandle->getStatus());

        $this->authorRepository->save($entity);
        return $entity;
    }

    /**
     * @param Authors $author
     * @return void
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function remove(Authors $author)
    {
        $this->authorRepository->delete($author);
    }
}
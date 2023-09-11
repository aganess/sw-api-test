<?php

namespace core\services\books;

use core\entities\Books;
use core\repositories\BookRepository;
use yii\db\StaleObjectException;

class BookService
{
    private BookRepository $bookRepository;

    /**
     * @param BookRepository $bookRepository
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param BookHandler $authorHandle
     * @return Books
     */
    public function add(BookHandler $authorHandle): Books
    {
        $entity = Books::make($authorHandle->getAuthorId(), $authorHandle->getLanguageId(), $authorHandle->getGenreId(), $authorHandle->getName(), $authorHandle->getDescription(),
            $authorHandle->getNumPages(), $authorHandle->getStatus()
        );
        $this->bookRepository->save($entity);
        return $entity;
    }

    public function edit(Books $entity, BookHandler $authorHandle)
    {
        $entity->edit($authorHandle->getAuthorId(), $authorHandle->getLanguageId(), $authorHandle->getGenreId(), $authorHandle->getName(), $authorHandle->getDescription(),
            $authorHandle->getNumPages(), $authorHandle->getStatus()
        );

        $this->bookRepository->save($entity);
        return $entity;
    }

    /**
     * @param Books $entity
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove(Books $entity)
    {
        $this->bookRepository->delete($entity);
    }
}
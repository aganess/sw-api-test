<?php

namespace core\services\genres;

use core\entities\Genres;
use core\repositories\GenreRepository;
use yii\db\StaleObjectException;

class GenreService
{
    private GenreRepository $genreRepository;

    /**
     * @param GenreRepository $genreRepository
     */
    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    /**
     * @param GenreHandler $genreHandler
     * @return Genres
     */
    public function add(GenreHandler $genreHandler): Genres
    {
        $entity = Genres::make($genreHandler->getGenreName(), $genreHandler->getStatus());
        $this->genreRepository->save($entity);

        return $entity;
    }

    /**
     * @param Genres $entity
     * @param GenreHandler $genreHandler
     * @return Genres
     */
    public function edit(Genres $entity, GenreHandler $genreHandler): Genres
    {
        $entity->edit($genreHandler->getGenreName(), $genreHandler->getStatus());
        $this->genreRepository->save($entity);

        return $entity;
    }

    /**
     * @param Genres $genre
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove(Genres $genre)
    {
        $this->genreRepository->delete($genre);
    }
}
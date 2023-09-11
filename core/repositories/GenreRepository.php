<?php

namespace core\repositories;

use core\entities\Genres;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class GenreRepository
{
    /**
     * @param $id
     * @return Genres
     * @throws NotFoundHttpException
     */
    public function get($id): Genres
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return Genres|null
     */
    public function getById(int $id): ?Genres
    {
        return Genres::findOne(['id' => $id]);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAll(): array
    {
        return Genres::find()->all();
    }

    /**
     * @param array $condition
     * @return Genres
     * @throws NotFoundHttpException
     */
    protected function getBy(array $condition): Genres
    {
        if (!$entity = Genres::findOne($condition)) {
            throw new NotFoundHttpException('Genre is not found.');
        }
        return $entity;
    }

    /**
     * @param Genres $entity
     * @return void
     */
    public function save(Genres $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Genres $entity
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Genres $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
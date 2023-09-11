<?php

namespace core\repositories;

use core\entities\Books;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class BookRepository
{
    /**
     * @param $id
     * @return Books
     * @throws NotFoundHttpException
     */
    public function get($id): Books
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return Books|null
     */
    public function getById(int $id): ?Books
    {
        return Books::findOne(['id' => $id]);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAll(): array
    {
        return Books::find()->all();
    }

    /**
     * @param array $condition
     * @return Books
     * @throws NotFoundHttpException
     */
    protected function getBy(array $condition): Books
    {
        if (!$entity = Books::findOne($condition)) {
            throw new NotFoundHttpException('Book is not found.');
        }
        return $entity;
    }

    /**
     * @param Books $entity
     * @return void
     */
    public function save(Books $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Books $entity
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Books $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
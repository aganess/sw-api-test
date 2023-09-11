<?php

namespace core\repositories;

use core\entities\Authors;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class AuthorRepository
{
    /**
     * @param $id
     * @return Authors
     * @throws NotFoundHttpException
     */
    public function get($id): Authors
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return Authors|null
     */
    public function getById(int $id): ?Authors
    {
        return Authors::findOne(['id' => $id]);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAll(): array
    {
        return Authors::find()->all();
    }

    /**
     * @param array $condition
     * @return Authors
     * @throws NotFoundHttpException
     */
    protected function getBy(array $condition): Authors
    {
        if (!$entity = Authors::findOne($condition)) {
            throw new NotFoundHttpException('Author is not found.');
        }
        return $entity;
    }

    /**
     * @param Authors $entity
     * @return void
     */
    public function save(Authors $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Authors $entity
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Authors $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
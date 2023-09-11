<?php

namespace core\repositories;

use core\entities\Languages;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class LanguageRepository
{
    /**
     * @param $id
     * @return Languages
     * @throws NotFoundHttpException
     */
    public function get($id): Languages
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return Languages|null
     */
    public function getById(int $id): ?Languages
    {
        return Languages::findOne(['id' => $id]);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAll(): array
    {
        return Languages::find()->all();
    }

    /**
     * @param array $condition
     * @return Languages
     * @throws NotFoundHttpException
     */
    protected function getBy(array $condition): Languages
    {
        if (!$entity = Languages::findOne($condition)) {
            throw new NotFoundHttpException('Language is not found.');
        }
        return $entity;
    }

    /**
     * @param Languages $entity
     * @return void
     */
    public function save(Languages $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Languages $entity
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Languages $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
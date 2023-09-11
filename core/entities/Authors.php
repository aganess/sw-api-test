<?php

namespace core\entities;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $name
 * @property string $birthdate
 * @property string $biography
 * @property int|null $status
 *
 * @property Books[] $books
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * @param $name
     * @param $birthdate
     * @param $biography
     * @param $status
     * @return static
     */
    public static function make($name, $birthdate, $biography, $status): Authors
    {
        $entity = new static();
        $entity->name = $name;
        $entity->birthdate = $birthdate;
        $entity->biography = $biography;
        $entity->status = $status;

        return $entity;
    }

    /**
     * @param $name
     * @param $birthdate
     * @param $biography
     * @param $status
     * @return void
     */
    public function edit($name, $birthdate, $biography, $status)
    {
        $this->name = $name;
        $this->birthdate = $birthdate;
        $this->biography = $biography;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'birthdate' => 'Birthdate',
            'biography' => 'Biography',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Books::class, ['author_id' => 'id']);
    }
}

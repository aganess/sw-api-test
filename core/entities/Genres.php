<?php

namespace core\entities;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "genres".
 *
 * @property int $id
 * @property string $genre_name
 * @property int $status
 *
 * @property Books[] $books
 */
class Genres extends \yii\db\ActiveRecord
{
    /**
     * @param $genreName
     * @param $status
     * @return static
     */
    public static function make($genreName, $status): Genres
    {
        $entity = new static();
        $entity->genre_name = $genreName;
        $entity->status = $status;

        return $entity;
    }

    /**
     * @param $genreName
     * @param $status
     * @return void
     */
    public function edit($genreName, $status)
    {
        $this->genre_name = $genreName;
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
        return 'genres';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'genre_name' => 'Genre Name',
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
        return $this->hasMany(Books::class, ['genre_id' => 'id']);
    }
}

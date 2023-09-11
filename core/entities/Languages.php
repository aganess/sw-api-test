<?php

namespace core\entities;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $language_name
 * @property string $iso_code
 * @property int $status
 *
 * @property Books[] $books
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @param $languageName
     * @param $isoCode
     * @param $status
     * @return Languages
     */
    public static function make($languageName, $isoCode, $status): Languages
    {
        $entity = new static();
        $entity->language_name = $languageName;
        $entity->iso_code = $isoCode;
        $entity->status = $status;

        return $entity;
    }

    /**
     * @param $languageName
     * @param $isoCode
     * @param $status
     * @return void
     */
    public function edit($languageName, $isoCode, $status)
    {
        $this->language_name = $languageName;
        $this->iso_code = $isoCode;
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
        return 'languages';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'language_name' => 'Language Name',
            'iso_code' => 'ISO',
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
        return $this->hasMany(Books::class, ['language_id' => 'id']);
    }
}

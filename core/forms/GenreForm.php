<?php

namespace core\forms;

use yii\base\Model;

class GenreForm extends Model
{
    public $genreName;
    public $status;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['genreName', 'status'], 'required'],
            [['genreName'], 'string', 'max' => 200, 'min' => 1],
            ['status', 'integer'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'genreName' => 'Жанр',
            'status' => 'Статус'
        ];
    }
}
<?php

namespace core\forms;

use yii\base\Model;

class AuthorForm extends Model
{
    public $name;
    public $birthdate;
    public $biography;
    public $status;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'biography', 'birthdate', 'status'], 'required'],
            [['name', 'biography'], 'string'],
            ['name', 'string', 'max' => 200, 'min' => 2],
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            ['status', 'integer', 'max' => 1000000],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Название автора',
            'biography' => 'Биография автора',
            'birthdate' => 'Дата рождения автора',
            'status' => 'Статус',
        ];
    }
}
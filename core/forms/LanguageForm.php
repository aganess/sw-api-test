<?php

namespace core\forms;

use core\entities\Languages;
use yii\base\Model;

class LanguageForm extends Model
{
    public $languageName;
    public $isoCode;
    public $status;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['languageName', 'isoCode', 'status'], 'required'],
            [['languageName'], 'string', 'max' => 200, 'min' => 1],
            [['isoCode'], 'string', 'max' => 50, 'min' => 1],
            //[['isoCode'], 'unique', 'targetClass' => Languages::class, 'targetAttribute' => 'iso_code', 'message' => 'This ISO code already exists.'],
            ['status', 'integer'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'languageName' => 'Язык',
            'isoCode' => 'ISO код',
            'status' => 'Статус'
        ];
    }
}
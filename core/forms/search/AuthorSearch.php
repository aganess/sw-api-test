<?php

namespace core\forms\search;

use core\entities\Authors;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Model
{
    public $name;
    public $birthdate;
    public $biography;
    public $status;
    public $created_at;

    public function rules(): array
    {
        return [
            [['name', 'biography'], 'string', 'max' => 200],
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            ['status', 'integer'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Authors::find();
        $tableName = Authors::tableName();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            $tableName . '.status' => $this->status,
            $tableName . '.birthdate' => $this->birthdate,
            $tableName . '.biography' => $this->biography,
        ]);

        $query->andFilterWhere(['like', $tableName . '.name', $this->name]);

        return $dataProvider;
    }

    /**
     * @return string[]
     */
    public static function getStatusList(): array
    {
        return [
            0 => 'Не активен',
            1 => 'Активен'
        ];
    }
}
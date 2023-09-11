<?php

namespace core\forms\search;

use core\entities\Authors;
use core\entities\Books;
use core\entities\Genres;
use core\entities\Languages;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BookSearch extends Model
{
    public $author_id;
    public $language_id;
    public $genre_id;
    public $name;
    public $description;
    public $num_pages;
    public $status;

    public $pageFrom;
    public $pageTo;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['pageFrom', 'pageTo'], 'integer'],
            [['name', 'description'], 'string', 'max' => 200],
            [['status'], 'integer'],
            [['author_id', 'language_id', 'genre_id'], 'safe']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Books::find();
        $tableName = Books::tableName();

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

        $query->andFilterWhere(['like', $tableName . '.name', $this->name])
            ->andFilterWhere(['like', $tableName . '.description', $this->description])
            ->andFilterWhere([$tableName . '.status' => $this->status])
            ->andFilterWhere(['>=', 'num_pages', $this->pageFrom])
            ->andFilterWhere(['<=', 'num_pages', $this->pageTo]);


        if (!empty($this->genre_id)) {
            $query->joinWith('genre');
            $query->andFilterWhere(['genres.id' => $this->genre_id]);
        }

        if (!empty($this->author_id)) {
            $query->joinWith('author');
            $query->andFilterWhere(['in', 'authors.id', $this->author_id]);
        }


        if (!empty($this->language_id)) {
            $query->joinWith('language');
            $query->andFilterWhere(['in', 'languages.id', $this->language_id]);
        }


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

    /**
     * @return array
     */
    public static function getAuthors(): array
    {
        return ArrayHelper::map(Authors::find()->asArray()->all(), 'id', 'name');
    }


    /**
     * @return array
     */
    public static function getLanguages(): array
    {
        return ArrayHelper::map(Languages::find()->asArray()->all(), 'id', 'language_name');
    }

    /**
     * @return array
     */
    public static function getGenres(): array
    {
        return ArrayHelper::map(Genres::find()->asArray()->all(), 'id', 'genre_name');
    }
}
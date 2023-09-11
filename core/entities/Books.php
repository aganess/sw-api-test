<?php

namespace core\entities;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int $author_id
 * @property int $language_id
 * @property int $genre_id
 * @property string $name
 * @property string $description
 * @property int $num_pages
 * @property int|null $status
 *
 * @property Authors $author
 * @property Genres $genre
 * @property Languages $language
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @param $authorId
     * @param $languageId
     * @param $genreId
     * @param $name
     * @param $description
     * @param $numPage
     * @param $status
     * @return Books
     */
    public static function make($authorId, $languageId, $genreId, $name, $description, $numPage, $status): Books
    {
        $entity = new static();
        $entity->author_id = $authorId;
        $entity->language_id = $languageId;
        $entity->genre_id = $genreId;
        $entity->name = $name;
        $entity->description = $description;
        $entity->num_pages = $numPage;
        $entity->status = $status;

        return $entity;
    }


    public function edit($authorId, $languageId, $genreId, $name, $description, $numPage, $status)
    {
        $this->author_id = $authorId;
        $this->language_id = $languageId;
        $this->genre_id = $genreId;
        $this->name = $name;
        $this->description = $description;
        $this->num_pages = $numPage;
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
        return 'books';
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return [
//            [['author_id', 'language_id', 'genre_id', 'name', 'description', 'num_pages'], 'required'],
//            [['author_id', 'language_id', 'genre_id', 'num_pages', 'status'], 'default', 'value' => null],
//            [['author_id', 'language_id', 'genre_id', 'num_pages', 'status'], 'integer'],
//            [['description'], 'string'],
//            [['name'], 'string', 'max' => 200],
//            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
//            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::class, 'targetAttribute' => ['genre_id' => 'id']],
//            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'language_id' => 'Language ID',
            'genre_id' => 'Genre ID',
            'name' => 'Name',
            'description' => 'Description',
            'num_pages' => 'Num Pages',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return ActiveQuery
     */
    public function getGenre(): ActiveQuery
    {
        return $this->hasOne(Genres::class, ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return ActiveQuery
     */
    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }
}

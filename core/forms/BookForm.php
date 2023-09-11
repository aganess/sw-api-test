<?php

namespace core\forms;

use core\entities\Authors;
use core\entities\Genres;
use core\entities\Languages;
use yii\base\Model;

class BookForm extends Model
{
    public $authorId;
    public $languageId;
    public $genreId;
    public $name;
    public $description;
    public $numPages;
    public $status;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['authorId', 'name', 'description', 'numPages', 'genreId', 'languageId', 'status'], 'required'],
            [['status', 'authorId', 'numPages', 'genreId', 'languageId'], 'integer'],
            [['description', 'name'], 'string', 'min' => 1, 'max' => 200],
            ['authorId', 'exist', 'targetClass' => Authors::class, 'targetAttribute' => 'id', 'message' => 'The author ID does not exist.'],
            ['genreId', 'exist', 'targetClass' => Genres::class, 'targetAttribute' => 'id', 'message' => 'The genre ID does not exist.'],
            ['languageId', 'exist', 'targetClass' => Languages::class, 'targetAttribute' => 'id', 'message' => 'The language ID does not exist.']

        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'authorId' => 'Author ID',
            'genreId' => 'Genre ID',
            'languageId' => 'Language ID',
            'name' => 'Book name',
            'description' => 'Description',
            'numPages' => 'Num Pages',
            'status' => 'Status',
        ];
    }

}
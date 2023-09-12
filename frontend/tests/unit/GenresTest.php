<?php
namespace frontend\tests;

use core\entities\Genres;
use core\forms\GenreForm;
use yii\db\StaleObjectException;

class GenresTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    protected function _before()
    {
        Genres::deleteAll(['genre_name' => 'Test Genre']);
    }

    /**
     * @return void
     */
    protected function _after()
    {
        Genres::deleteAll(['genre_name' => 'Test Genre']);
    }

    /**
     * @return void
     */
    public function testGenreValidation()
    {
        $genre = new GenreForm();

        // Проверка, что genre_name обязательное поле
        $genre->status = 1;
        $this->assertFalse($genre->validate(['genreName']), 'Genre name is required');

        // Проверка, что status обязательное поле
        $genre->genreName = 'Test Genre';
        $genre->status = null;
        $this->assertFalse($genre->validate(['status']), 'Status is required');
    }

    /**
     * @return void
     */
    public function testInvalidGenreSave()
    {
        $genre = new Genres();

        $genre->genre_name = ''; // пустое имя
        $genre->status = 1;
        $this->assertFalse($genre->save(), 'Failed: Genre should not save with an empty name');

        $genre->genre_name = 'Test Genre';
        $genre->status = null; // отсутствующий статус
        $this->assertFalse($genre->save(), 'Failed: Genre should not save without a status');
    }

    /**
     * @return void
     */
    public function testUpdateGenre()
    {
        $genre = new Genres();
        $genre->genre_name = 'Test Genre';
        $genre->status = 1;
        $genre->save();

        $retrievedGenre = Genres::findOne($genre->id);
        $retrievedGenre->genre_name = 'Updated Genre';
        $this->assertTrue($retrievedGenre->save(), 'Failed to update genre');

        $updatedGenre = Genres::findOne($retrievedGenre->id);
        $this->assertEquals('Updated Genre', $updatedGenre->genre_name, 'Genre name was not updated');
    }

    /**
     * @return void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function testDeleteGenre()
    {
        $genre = new Genres();
        $genre->genre_name = 'Test Genre';
        $genre->status = 1;
        $genre->save();

        $retrievedGenre = Genres::findOne($genre->id);
        $this->assertNotNull($retrievedGenre, 'Genre not retrieved from database');

        $retrievedGenre->delete();

        $deletedGenre = Genres::findOne($retrievedGenre->id);
        $this->assertNull($deletedGenre, 'Failed to delete genre from database');
    }

}
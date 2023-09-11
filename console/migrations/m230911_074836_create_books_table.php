<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m230911_074836_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
            'name' => $this->string(200)->notNull(),
            'description' => $this->text()->notNull(),
            'num_pages' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-author-id', 'books', 'author_id');
        $this->createIndex('idx-language-id', 'books', 'language_id');
        $this->createIndex('idx-genre-id', 'books', 'genre_id');
        $this->createIndex('idx-books-name', 'books', 'name');


        $this->addForeignKey(
            'fk-books-author_id',
            '{{%books}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-books-language_id',
            '{{%books}}',
            'language_id',
            '{{%languages}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-books-genre_id',
            '{{%books}}',
            'genre_id',
            '{{%genres}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}

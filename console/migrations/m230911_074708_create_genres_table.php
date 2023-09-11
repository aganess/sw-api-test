<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%genres}}`.
 */
class m230911_074708_create_genres_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%genres}}', [
            'id' => $this->primaryKey(),
            'genre_name' => $this->string(200)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%genres}}');
    }
}

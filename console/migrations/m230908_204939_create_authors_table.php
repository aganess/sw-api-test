<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m230908_204939_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'birthdate' => $this->date()->notNull(),
            'biography' => $this->text()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);
        $this->createIndex('idx-authors-name', 'authors', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}

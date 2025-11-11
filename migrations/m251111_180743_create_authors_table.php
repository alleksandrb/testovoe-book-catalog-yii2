<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m251111_180743_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull()->comment('ФИО автора'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-authors-full_name', '{{%authors}}', 'full_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%authors}}');
    }
}

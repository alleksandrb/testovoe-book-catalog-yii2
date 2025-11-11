<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m251111_180747_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название'),
            'year' => $this->integer()->notNull()->comment('Год выпуска'),
            'description' => $this->text()->comment('Описание'),
            'isbn' => $this->string(20)->notNull()->unique()->comment('ISBN'),
            'cover_image' => $this->string(500)->comment('Фото главной страницы'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-books-year', '{{%books}}', 'year');
        $this->createIndex('idx-books-isbn', '{{%books}}', 'isbn', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%books}}');
    }
}

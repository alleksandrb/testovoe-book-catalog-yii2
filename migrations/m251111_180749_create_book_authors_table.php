<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_authors}}`.
 */
class m251111_180749_create_book_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%book_authors}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-book_authors', '{{%book_authors}}', ['book_id', 'author_id']);
        $this->addForeignKey(
            'fk-book_authors-book_id',
            '{{%book_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-book_authors-author_id',
            '{{%book_authors}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%book_authors}}');
    }
}

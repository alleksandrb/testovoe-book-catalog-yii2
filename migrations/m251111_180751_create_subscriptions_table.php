<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m251111_180751_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull()->comment('ID автора'),
            'phone' => $this->string(20)->notNull()->comment('Телефон для SMS'),
            'user_id' => $this->integer()->null()->comment('ID пользователя, если авторизован'),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        // user_id может быть NULL для гостей, внешний ключ не добавляем

        $this->createIndex('idx-subscriptions-author_phone', '{{%subscriptions}}', ['author_id', 'phone'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%subscriptions}}');
    }
}

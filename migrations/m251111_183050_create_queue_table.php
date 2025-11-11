<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m251111_183050_create_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'job_class' => $this->string(255)->notNull()->comment('Класс задачи'),
            'job_data' => $this->text()->notNull()->comment('Данные задачи (JSON)'),
            'status' => $this->string(20)->notNull()->defaultValue('pending')->comment('Статус: pending, processing, completed, failed'),
            'attempts' => $this->integer()->notNull()->defaultValue(0)->comment('Количество попыток'),
            'created_at' => $this->integer()->notNull()->comment('Время создания'),
            'started_at' => $this->integer()->null()->comment('Время начала обработки'),
            'finished_at' => $this->integer()->null()->comment('Время завершения'),
            'error' => $this->text()->null()->comment('Ошибка'),
        ]);

        $this->createIndex('idx-queue-status', '{{%queue}}', 'status');
        $this->createIndex('idx-queue-created_at', '{{%queue}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%queue}}');
    }
}

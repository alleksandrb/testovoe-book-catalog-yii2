<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Queue Job model
 *
 * @property int $id
 * @property string $job_class
 * @property string $job_data
 * @property string $status
 * @property int $attempts
 * @property int $created_at
 * @property int|null $started_at
 * @property int|null $finished_at
 * @property string|null $error
 */
class QueueJob extends ActiveRecord
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%queue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['job_class', 'job_data', 'status', 'attempts', 'created_at'], 'required'],
            [['job_data', 'error'], 'string'],
            [['attempts', 'created_at', 'started_at', 'finished_at'], 'integer'],
            [['job_class'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_COMPLETED, self::STATUS_FAILED]],
        ];
    }

    public function getJobData(): array
    {
        return json_decode($this->job_data, true);
    }
}


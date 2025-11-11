<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Book model
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $cover_image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Author[] $authors
 */
class Book extends ActiveRecord
{
    /**
     * @var UploadedFile|null
     */
    public $coverFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%books}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer', 'min' => 1000, 'max' => 9999],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            [['cover_image'], 'string', 'max' => 500],
            [['coverFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Фото главной страницы',
            'coverFile' => 'Файл обложки',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%book_authors}}', ['book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }
            $this->updated_at = time();
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        
        if ($this->coverFile) {
            $this->uploadCover();
        }
    }

    /**
     * Gets the full URL for the cover image
     * @return string|null
     */
    public function getCoverImageUrl(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }
        return \Yii::getAlias('@web/' . $this->cover_image);
    }

    /**
     * Uploads cover image
     */
    protected function uploadCover(): void
    {
        if ($this->coverFile) {
            $path = 'uploads/covers/' . $this->id . '.' . $this->coverFile->extension;
            $fullPath = \Yii::getAlias('@webroot/' . $path);
            $dir = dirname($fullPath);
            
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
                chmod($dir, 0777);
            }
            
            if ($this->coverFile->saveAs($fullPath)) {
                chmod($fullPath, 0666);
                $this->cover_image = $path;
                $this->updateAttributes(['cover_image']);
            }
        }
    }
}


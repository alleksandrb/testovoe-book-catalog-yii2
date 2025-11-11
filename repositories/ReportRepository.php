<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Author;

class ReportRepository implements ReportRepositoryInterface
{
    public function getTopAuthorsByYear(int $year, int $limit = 10): array
    {
        return Author::find()
            ->select([
                'author_id' => '{{%authors}}.id',
                'author_name' => '{{%authors}}.full_name',
                'books_count' => 'COUNT({{%book_authors}}.book_id)'
            ])
            ->innerJoin('{{%book_authors}}', '{{%book_authors}}.author_id = {{%authors}}.id')
            ->innerJoin('{{%books}}', '{{%books}}.id = {{%book_authors}}.book_id')
            ->where(['{{%books}}.year' => $year])
            ->groupBy(['{{%authors}}.id', '{{%authors}}.full_name'])
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();
    }
}


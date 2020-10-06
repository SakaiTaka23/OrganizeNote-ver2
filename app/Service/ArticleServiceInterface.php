<?php

namespace App\Service;

use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceInterface
{
    public function getIndex(int $auth_id, int $paginate): LengthAwarePaginator;

    public function findArticle(int $auth_id, string $datefrom = null, string $min_date, string $dateto = null, string $max_date, string $title = null, int $paginate): LengthAwarePaginator;
}

<?php

namespace App\Service;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TagServiceInterface
{
    public function getTags(int $auth_id, int $paginate): LengthAwarePaginator;

    public function getTagName(int $id): String;

    public function getArticles(int $auth_id, int $id): Collection;
}

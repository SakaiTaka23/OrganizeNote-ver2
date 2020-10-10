<?php

namespace App\Service;

use Illuminate\Pagination\LengthAwarePaginator;

interface TableOfContentInterface
{
    public function getRandomContents(int $auth_id, int $paginate): LengthAwarePaginator;

    public function findContents(int $auth_id, string $contnet = null, int $paginate): LengthAwarePaginator;
}

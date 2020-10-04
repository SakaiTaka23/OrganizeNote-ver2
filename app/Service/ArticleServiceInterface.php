<?php

namespace App\Service;

interface ArticleServiceInterface
{
    public function getIndex($paginate);

    public function findArticle($datefrom, $min_date, $dateto, $max_date, $title, $paginate);
}

<?php

namespace App\Service;

interface ArticleServiceInterface
{
    public function getIndex($auth_id,$paginate);

    public function findArticle($auth_id,$datefrom, $min_date, $dateto, $max_date, $title, $paginate);
}

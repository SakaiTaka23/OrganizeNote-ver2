<?php

namespace App\Service;

interface ArticleServiceInterface
{
    public function getIndex();

    public function findArticle($request);

}

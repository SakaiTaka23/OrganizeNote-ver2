<?php

namespace App\Service;

interface ArticleServiceInterface
{

    public function users();

    public function contents();

    public function tags();

    public function getIndex();

    public function findArticle();

}

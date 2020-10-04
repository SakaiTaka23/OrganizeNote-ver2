<?php

namespace App\Service;

interface TagServiceInterface
{
    public function getTags($paginate);

    public function getTagName($id);

    public function getArticles($id);
}

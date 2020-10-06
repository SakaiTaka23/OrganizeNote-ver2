<?php

namespace App\Service;

interface TagServiceInterface
{
    public function getTags($auth_id, $paginate);

    public function getTagName($id);

    public function getArticles($auth_id, $id);
}

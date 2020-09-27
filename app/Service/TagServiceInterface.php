<?php

namespace App\Service;

interface TagServiceInterface
{
    public function getTags();

    public function getTagName($id);

    public function getArticles($id);
}

<?php

namespace App\Service;

interface TagServiceInterface
{

    public function articles();

    public function users();

    public function getTags();

    public function getTagName();

    public function getArticles();
}

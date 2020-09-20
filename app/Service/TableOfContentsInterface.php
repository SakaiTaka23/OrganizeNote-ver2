<?php

namespace App\Service;

interface TableOfContents
{

    public function articles();

    public function users();

    public function getRandomContents();

    public function findContents();
}

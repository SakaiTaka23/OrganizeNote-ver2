<?php

namespace App\Service;

interface TableOfContentInterface
{
    public function getRandomContents($paginate);

    public function findContents($contnet, $paginate);
}

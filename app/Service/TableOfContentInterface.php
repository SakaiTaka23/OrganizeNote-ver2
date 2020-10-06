<?php

namespace App\Service;

interface TableOfContentInterface
{
    public function getRandomContents($auth_id, $paginate);

    public function findContents($auth_id, $contnet, $paginate);
}

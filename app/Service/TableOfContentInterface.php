<?php

namespace App\Service;

interface TableOfContentInterface
{
    public function getRandomContents();

    public function findContents($request);

}

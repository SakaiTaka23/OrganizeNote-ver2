<?php

namespace App\Service;

interface UserServiceInterface
{
    public function updateCount($name);

    public function getProfile($name);

    public function getNoteid($id);
}

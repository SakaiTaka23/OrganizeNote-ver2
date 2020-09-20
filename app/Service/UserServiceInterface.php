<?php

namespace App\Service;

interface UserServiceInterface
{

    public function articles();

    public function tableofcontents();

    public function tags();

    public function updateCount($name);

    public function getProfile($name);
}

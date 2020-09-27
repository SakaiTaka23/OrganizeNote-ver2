<?php

namespace App\Service\Production;

use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->auth = Auth::user();
    }

    //その人が投稿した記事の数を更新する
    public function updateCount($name)
    {
    }

    //その人のプロフィールをとってくる
    public function getProfile($name)
    {
    }

    //idを受け取りnoteidを返す
    public function getNoteid($id)
    {
        return $this->user->noteid;
    }
}

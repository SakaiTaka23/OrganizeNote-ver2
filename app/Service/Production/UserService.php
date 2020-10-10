<?php

namespace App\Service\Production;

use GuzzleHttp\Client;

use App\Service\UserServiceInterface;
use App\Models\User;

class UserService implements UserServiceInterface
{
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //その人が投稿した記事の数を更新する
    public function updateCount($name)
    {
    }

    //その人のプロフィールをとってくる
    public function getProfile($name)
    {
        $url = 'https://note.com/api/v2/creators/' . $name;
        $client = new Client();
        $response = $client->request("GET", $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $posts = $posts['data'];

        $profile['nickname'] = $posts['nickname'];
        $profile['urlname'] = $posts['urlname'];
        $profile['profile'] = $posts['profile'];
        $profile['noteCount'] = $posts['noteCount'];
        $profile['followingCount'] = $posts['followingCount'];
        $profile['followerCount'] = $posts['followerCount'];
        if (isset($posts['socials']['twitter']['nickname'])) {
            $profile['twitter'] = '@' . $posts['socials']['twitter']['nickname'];
        }
        return $profile;
    }
}

<?php

namespace App\Console\Commands\Utils;

use GuzzleHttp\Client;

use App\Models\Article;
use App\Models\User;
use App\Models\TableOfContent;
use App\Models\Tag;

class CommandUtils
{
    public function __construct(Article $article, Client $client, TableOfContent $tableOfContent, Tag $tag, User $user)
    {
        $this->article = $article;
        $this->client = $client;
        $this->tableofcontent = $tableOfContent;
        $this->tag = $tag;
        $this->user = $user;
    }

    public function saveArticle_attach($post, $user_id)
    {
        $this->article = new Article();
        $this->article->title = $post['name'];
        $this->article->key = $post['key'];
        $this->article->user_id = $user_id;
        $this->article->created_at = $post['publishAt'];
        $this->article->save();

        if (isset($post['hashtags'])) {
            $hashtags = $post['hashtags'];
            for ($j = 0; $j < count($post['hashtags']); $j++) {
                $tag = $hashtags[$j]['hashtag']['name'];
                $tags = $this->tag->firstOrCreate(['name' => $tag, 'user_id' => $user_id]);
                $tags->articles()->attach($this->article);
            }
        }

        if (isset($post['additionalAttr']['index'])) {
            $contentstable = $post['additionalAttr']['index'];
            for ($j = 0; $j < count($contentstable); $j++) {
                $content = $contentstable[$j]['body'];
                $contents = $this->tableofcontent->firstOrCreate(['name' => $content, 'user_id' => $user_id]);
                $contents->articles()->attach($this->article);
            }
        }
    }

    public function updateCount($name, $user_id)
    {
        $url = 'https://note.com/api/v2/creators/' . $name;
        $response = $this->client->request("GET", $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $count = $posts['data']['noteCount'];
        $user = $this->user->find($user_id);

        $user->fill(['article_count' => $count])->update();
        return $count;
    }
}

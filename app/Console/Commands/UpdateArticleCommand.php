<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Models\Article;
use App\models\TableOfContent;
use App\Models\Tag;
use App\Models\User;

class UpdateArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get users(first_task_finished is true) articles that are recently published';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Article $article, Carbon $carbon, Client $client, TableOfContent $tableofcontent, Tag $tag, User $user)
    {
        $this->article = $article;
        $this->carbon = $carbon;
        $this->client = $client;
        $this->tableofcontent = $tableofcontent;
        $this->tag = $tag;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $need_update_user = $this->user->where('first_task_finished', 1)->get();
        foreach ($need_update_user as $user) {
            $this->updateCount($user->noteid, $user->id);
            $this->get_resent_articles($user->noteid, $user->id);
        }
        return 0;
    }

    public function get_resent_articles($note_id, $user_id)
    {
        $page = 1;
        $url = 'https://note.com/api/v2/creators/' . $note_id . '/contents?kind=note&page=' . $page;
        $response = $this->client->request("GET", $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $posts = $posts['data']['contents'];

        $resent_posts = [];
        foreach ($posts as $post) {
            $publishedAt = $this->carbon->parse($post['publishAt']);
            if ($publishedAt->isYesterday()) {
                if ($post['type'] == 'TextNote') {
                    array_unshift($resent_posts, $post);
                }
            } else {
                break;
            }
        }

        foreach ($resent_posts as $post) {
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
        sleep(1);
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

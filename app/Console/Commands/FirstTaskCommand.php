<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;

use App\Models\Article;
use App\Models\TableOfContent;
use App\Models\Tag;
use App\Models\User;

class FirstTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:first-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all article where users first task is false';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(User $user)
    {
        $resent_user = $user->where('first_task_finished', 0)->get();
        foreach ($resent_user as $user) {
            $this->first_time($user->noteid, $user->id);
            $user->first_task_finished = true;
            $user->save();
        }
        return 0;
    }

    // noteid,そのuser_idを渡すと記事を全取得する
    public function first_time($name, $user_id)
    {
        $count = $this->updateCount($name, $user_id);
        $page = intval($count / 6);
        if ($page % 6 != 0) $page++;

        for ($page; $page >= 1; $page--) {
            $url = 'https://note.com/api/v2/creators/' . $name . '/contents?kind=note&page=' . $page;
            $client = new Client();
            $response = $client->request("GET", $url);
            $posts = $response->getBody();
            $posts = json_decode($posts, true);
            $posts = $posts['data']['contents'];
            //dd(count($posts),$posts);

            for ($i = count($posts); $i > 0; $i--) {
                $anarticle = $posts[$i - 1];
                if ($anarticle['type'] != 'TextNote') {
                    continue;
                }
                $article = new Article();
                $article->title = $anarticle['name'];
                $article->key = $anarticle['key'];
                $article->user_id = $user_id;
                $article->created_at = $anarticle['publishAt'];
                $article->save();

                if (isset($anarticle['hashtags'])) {
                    $hashtags = $anarticle['hashtags'];
                    for ($j = 0; $j < count($anarticle['hashtags']); $j++) {
                        $tag = $hashtags[$j]['hashtag']['name'];
                        $tags = Tag::firstOrCreate(['name' => $tag, 'user_id' => $user_id]);
                        $tags->articles()->attach($article);
                    }
                }

                if (isset($anarticle['additionalAttr']['index'])) {
                    $contentstable = $anarticle['additionalAttr']['index'];
                    for ($j = 0; $j < count($contentstable); $j++) {
                        $content = $contentstable[$j]['body'];
                        $contents = TableOfContent::firstOrCreate(['name' => $content, 'user_id' => $user_id]);
                        $contents->articles()->attach($article);
                    }
                }
            }
            sleep(1);
        }
    }

    public function updateCount($name, $user_id)
    {
        $url = 'https://note.com/api/v2/creators/' . $name;
        $client = new Client();
        $response = $client->request("GET", $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $count = $posts['data']['noteCount'];
        $user = User::find($user_id);

        $user->fill(['article_count' => $count])->update();
        return $count;
    }
}

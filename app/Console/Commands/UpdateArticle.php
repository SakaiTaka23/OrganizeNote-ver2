<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Client;

use App\Models\Article;
use App\models\TableOfContent;
use App\Models\Tag;
use App\Models\User;

class UpdateArticle extends Command
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
    protected $description = 'get users articles that are recently published';

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
    public function handle()
    {
        return 0;
    }

    public function login_check($user, $user_id, $noteid)
    {
        $last_date = DB::table('articles')->select('created_at')->latest()->first();

        $user = new User;
        //$auth = Auth::user();
        $name = $noteid;
        $count = $user->updateCount($name);
        $page_max = intval($count / 6);
        if ($page_max % 6 != 0) $page_max++;
        $page = 1;
        //$found = false;

        for ($page; $page <= $page_max; $page++) {
            $url = 'https://note.com/api/v2/creators/' . $name . '/contents?kind=note&page=' . $page;
            $client = new Client();
            $response = $client->request("GET", $url);
            $posts = $response->getBody();
            $posts = json_decode($posts, true);
            $posts = $posts['data']['contents'];

            // for ($i = 0; $i < count($posts); $i++) {
            //     $anarticle = $posts[$i];
            //     if ($last_date >= $anarticle['publishAt']) {
            //         $found = true;
            //         break;
            //     }
            // }

            $anarticle = $posts[count($posts) - 1];
            if ($last_date >= $anarticle['publishAt']) {
                break;
            } else {
                sleep(1);
            }

            // if ($found) {
            //     break;
            // }
            //sleep(1);
        }

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
                $article->key = $anarticle['key'];
                $exists = DB::table('articles')->where('key', $article->key)->exists();
                if ($exists) {
                    continue;
                }

                $article->title = $anarticle['name'];
                //$article->key = $anarticle['key'];
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
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
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
    public function handle(User $user)
    {
        $need_update_user = $user->where('first_task_finished', 1)->get();
        //$now = Carbon::now();
        $now = new Carbon('2020/10/14');
        $subMonths = $now->subMonth(1);
        foreach ($need_update_user as $user) {
            $this->get_resent_articles($user->noteid, $user->id, $now, $subMonths);
        }
        return 0;
    }

    public function get_resent_articles($note_id, $user_id, $now, $subMonths)
    {
        $page = 1;
        $url = 'https://note.com/api/v2/creators/' . $note_id . '/contents?kind=note&page=' . $page;
        $client = new Client();
        $response = $client->request("GET", $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $posts = $posts['data']['contents'];

        $resent_posts = [];
        foreach ($posts as $post) {
            $publishedAt = new Carbon($post['publishAt']);
            if ($publishedAt->between($subMonths, $now)) {
                if ($post['type'] == 'TextNote') {
                    array_unshift($resent_posts, $post);
                }
            } else {
                break;
            }
        }
        print('resentposts');
        dd($resent_posts);
        print('ok');
        foreach ($resent_posts as $post) {
            $article = new Article();
            $article->title = $post['name'];
            $article->key = $post['key'];
            $article->user_id = $user_id;
            $article->created_at = $post['publishAt'];
            $article->save();

            if (isset($post['hashtags'])) {
                $hashtags = $post['hashtags'];
                for ($j = 0; $j < count($post['hashtags']); $j++) {
                    $tag = $hashtags[$j]['hashtag']['name'];
                    $tags = Tag::firstOrCreate(['name' => $tag, 'user_id' => $user_id]);
                    $tags->articles()->attach($article);
                }
            }

            if (isset($post['additionalAttr']['index'])) {
                $contentstable = $post['additionalAttr']['index'];
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

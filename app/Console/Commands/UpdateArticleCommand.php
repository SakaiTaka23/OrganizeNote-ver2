<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Console\Commands\SaveCommands\CommandUtils;
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
    public function __construct(Carbon $carbon, Client $client, CommandUtils $commandUtils, User $user)
    {
        $this->carbon = $carbon;
        $this->client = $client;
        $this->commandutils = $commandUtils;
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
            $this->commandutils->updateCount($user->noteid, $user->id);
            $this->fetch_resent_articles($user->noteid, $user->id);
        }
        return 0;
    }

    public function fetch_resent_articles($note_id, $user_id)
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
            $this->commandutils->saveArticle_attach($post, $user_id);
        }
        sleep(1);
    }
}

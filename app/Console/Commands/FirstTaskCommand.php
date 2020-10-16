<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;

use App\Console\Commands\Utils\CommandUtils;
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
    public function __construct(Client $client, CommandUtils $commandUtils, User $user)
    {
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
        $resent_user = $this->user->where('first_task_finished', 0)->get();
        foreach ($resent_user as $user) {
            $count = $this->commandutils->updateCount($user->noteid, $user->id);
            $this->first_time($count, $user->noteid, $user->id);
            $user->first_task_finished = true;
            $user->save();
        }
        return 0;
    }

    // noteid,そのuser_idを渡すと記事を全取得する
    public function first_time($count, $name, $user_id)
    {
        $page = intval($count / 6);
        if ($page % 6 != 0) $page++;
        if ($page == 0) $page++;

        for ($page; $page >= 1; $page--) {
            $url = 'https://note.com/api/v2/creators/' . $name . '/contents?kind=note&page=' . $page;
            $response = $this->client->request("GET", $url);
            $posts = $response->getBody();
            $posts = json_decode($posts, true);
            $posts = $posts['data']['contents'];

            for ($i = count($posts); $i > 0; $i--) {
                $anarticle = $posts[$i - 1];
                if ($anarticle['type'] != 'TextNote') {
                    continue;
                }
                $this->commandutils->saveArticle_attach($anarticle, $user_id);
            }
            sleep(1);
        }
    }
}

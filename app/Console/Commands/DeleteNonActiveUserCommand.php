<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Models\User;

class DeleteNonActiveUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-non-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete users that are not logged in more than a month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $user;

    public function __construct(User $user,Carbon $carbon)
    {
        $this->carbon = $carbon;
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
        $now = $this->carbon->now();
        $subMonths = $now->copy()->subMonth(1);
        $this->user->whereNotBetween('last_login', [$subMonths, $now])->delete();
        return 0;
    }
}

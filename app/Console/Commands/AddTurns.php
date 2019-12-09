<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class AddTurns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:turns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds turns to users';

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
     * @return mixed
     */
    public function handle()
    {
        $turns_each = 5;
        foreach (User::all() as $user) {
            $user->turns += $turns_each;
            if ($user->turns > $user->turns_stored_max) {
                $user->turns = $user->turns_stored_max;
            }
            $user->save();
        }
    }
}

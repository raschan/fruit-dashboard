<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetEvents extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command saves all the stripe events of all users.';

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
    public function fire()
    {
        Log::info('GetEvents fired');
        // going through the users
        foreach (User::all() as $user) {

            // saving events
            Calculator::saveEvents($user);
        }
        Log::info('GetEvents finished');
    }
}

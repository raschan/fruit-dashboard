<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateMetrics extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'metrics:calc';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Calculates the daily metrics from stored events';

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
    	Log::info('CalculateMetrics fired');
		// going through the users
        foreach (User::all() as $user) {
        	// check if user is connected
        	if($user->isStripeConnected())
        	{
        		// saving events
	            Calculator::calculateMetrics($user,time());
	        }
        }
	}
}

<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TrialEndCheck extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'check:trial';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks trial period end for each user who is not already subscribed';

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
		$users = User::all();

		foreach ($users as $user) 
		{
			if($user->isTrialEnded())
			{
				if ($user->plan == 'trial')
				{ 
					// this is the first time we are checking it
					$user->plan = 'trial_ended';
	            	$user->save();
					
					// 'trial ended' actions come here
				} 
			}
			if($user->trialWillEndExactlyInDays(3)) 
			{
				// 'trial will end' actions come here
			}
			if($user->trialWillEndExactlyInDays(-1))
			{
				// 'after 1 day' action
			}
			if($user->trialWillEndExactlyInDays(-7))
			{
				// 'after 7 days' action
			}
			if($user->trialWillEndExactlyInDays(-14))
			{
				// 'after 17 days' action
			}
		}
	}
}
